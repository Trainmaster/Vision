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
    /** @type int ENC_SERIALIZE */
    const ENC_SERIALIZE = 1;
    
    /** @type int ENC_JSON */
    const ENC_JSON = 2;
    
    /** @type int $cacheDir */
    protected $cacheDir = null;
    
    /** @type int $encoding */
    protected $encoding = self::ENC_SERIALIZE;
    
    /**
     * @param array $options  
     */
    public function __construct(array $options = array())
    {
        if (isset($options['cache_dir'])) {
            $this->cacheDir = rtrim($options['cache_dir'], '\\/');
        }
        
        if (isset($options['encoding'])) {
            $this->encoding = $options['encoding'];
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
        switch ($this->encoding) {
            case self::ENC_SERIALIZE:
                $data = serialize($value);
                break;
            
            case self::ENC_JSON:
                $data = json_encode($value);
                break;            
        }

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
            return null;
        }
        
        $file = new \SplFileObject($filename, 'r');
        
        $time = time();
        $mTime = $file->getMTime();
        
        $diff = $time - $mTime;

        $expiration = (int) $file->fgets();
        
        if ($expiration > 0 && $diff > $expiration) {
            unset($file);   
            unlink($filename);
            return null;
        }
        
        ob_start();        
        $file->fpassthru();        
        $data = ob_get_clean();
               
        switch ($this->encoding) {
            case self::ENC_SERIALIZE:
                $value = unserialize($data);
                break;
            
            case self::ENC_JSON:
                $value = json_decode($data);
                break;            
        }
        
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
        return $filename;        
    }
    
    /**
     * This method performs several checks in order
     * to validate a possible given cache directory.
     *
     * @internal
     * 
     * @return bool
     */
    protected function validateCacheDirectory()
    {
        if (!isset($this->cacheDir)){
            return false;
        }
        
        if (is_dir($this->cacheDir)) {
            return true;
        }   
        
        if (mkdir($this->cacheDir, 0600)) {
            return true;
        }
        
        return false;
    }
}