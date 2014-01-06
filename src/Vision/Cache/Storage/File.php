<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Cache\Storage;

/**
 * File
 *
 * @author Frank Liepert
 */
class File implements StorageInterface
{
    /** @type null|string $cacheDir */
    protected $cacheDir;

    /** @type int $cacheDirChmod */
    protected $cacheDirChmod = 0755;

    /** @type null|string $cacheFileExtension */
    protected $cacheFileExtension = '.cache';

    /**
     * @param array $options {
     *     @type string $cache_dir            An optional cache directory
     *     @type string $cache_dir_chmod      Default chmod when creating the caching directory
     *     @type string $cache_file_extension An optional file extension
     * }
     */
    public function __construct(array $options = array())
    {
        $this->cacheDir = sys_get_temp_dir();

        if (isset($options['cache_dir_chmod'])) {
            $this->cacheDirChmod = $options['cache_dir_chmod'];
        }

        if (isset($options['cache_file_extension'])) {
            $this->cacheFileExtension = pathinfo($options['cache_file_extension'], PATHINFO_EXTENSION);
        }
    }

    /**
     * @api
     *
     * @param string $cacheDir
     *
     * @return $this Provides a fluent interface.
     */
    public function setCacheDir($cacheDir)
    {
        $cacheDir = rtrim($cacheDir, '\\/');

        if (is_dir($cacheDir)) {
            $this->cacheDir = realpath($cacheDir);
            return $this;
        }

        if (mkdir($cacheDir, $this->cacheDirChmod, true)
            && chmod($cacheDir, $this->cacheDirChmod)
        ) {
            $this->cacheDir = realpath($cacheDir);
        }

        return $this;
    }

    /**
     * @api
     *
     * @param string $key
     * @param bool|int|float|string|array|object $value
     * @param int $expiration
     *
     * @return $this Provides a fluent interface.
     */
    public function set($key, $value, $expiration = 0)
    {
        $data = serialize($value);

        $filename = $this->prepareFilename($key);

        $file = new \SplFileObject($filename, 'w');

        $expiration = (int) $expiration;

        if ($file->flock(LOCK_EX)) {
            $file->ftruncate(0);
            $file->fwrite($expiration . "\n" . $data);
            $file->next();
            $file->flock(LOCK_UN);
        }

        return $this;
    }

    /**
     * @api
     *
     * @param string $key
     *
     * @return bool|int|float|string|array|object|null
     */
    public function get($key)
    {
        $filename = $this->prepareFilename($key);
        $filename = realpath($filename);

        if (!$filename) {
            return;
        }

        $file = new \SplFileObject($filename, 'r');

        $time = time();
        $mTime = $file->getMTime();

        $diff = $time - $mTime;

        $expiration = (int) $file->fgets();

        if ($expiration > 0 && $diff > $expiration) {
            unset($file);
            unlink($filename);
            return;
        }

        ob_start();
        $file->fpassthru();
        $data = ob_get_clean();
        $value = unserialize($data);

        return $value;
    }

    /**
     * In case a set cache directory can be validated,
     * prepend it to the filename.
     *
     * @internal
     *
     * @param string $filename
     *
     * @return string
     */
    protected function prepareFilename($filename)
    {
        $filename = $this->cacheDir . DIRECTORY_SEPARATOR . $filename;

        if (!empty($this->cacheFileExtension)) {
            $filename = $filename . '.' . $this->cacheFileExtension;
        }

        return $filename;
    }
}
