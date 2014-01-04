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

    /** @type null|string $cacheFileExtension */
    protected $cacheFileExtension;

    /**
     * @param array $options {
     *     @type string $cache_dir            An optional cache directory
     *     @type string $cache_file_extension An optional file extension
     * }
     */
    public function __construct(array $options = array())
    {
        if (isset($options['cache_dir'])) {
            $this->cacheDir = rtrim($options['cache_dir'], '\\/');
        }

        if (isset($options['cache_file_extension'])) {
            $this->cacheFileExtension = pathinfo($options['cache_file_extension'], PATHINFO_EXTENSION);
        }
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
        if ($this->validateCacheDirectory()) {
            $filename = $this->cacheDir . DIRECTORY_SEPARATOR . $filename;
        }

        if (!empty($this->cacheFileExtension)) {
            $filename = $filename . '.' . $this->cacheFileExtension;
        }

        return $filename;
    }

    /**
     * This method performs several checks in order
     * to validate a possible given cache directory.
     *
     * @internal
     *
     * @return bool
     *
     * @todo Make chmod configurable when calling mkdir()
     */
    protected function validateCacheDirectory()
    {
        if (!isset($this->cacheDir)){
            return false;
        }

        if (is_dir($this->cacheDir)) {
            return true;
        }

        if (mkdir($this->cacheDir, 0755)) {
            return true;
        }

        return false;
    }
}
