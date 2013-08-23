<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Cache\Adapter;

/**
 * File
 *
 * @author Frank Liepert
 */
class File implements AdapterInterface
{
    /** @type int ENC_SERIALIZE */
    const ENC_SERIALIZE = 1;
    
    /** @type int ENC_JSON */
    const ENC_JSON = 2;
    
    /** @type int $encoding */
    protected $encoding = self::ENC_SERIALIZE;
    
    /**
     * @param array $options  
     */
    public function __construct(array $options = array())
    {        
        if (isset($options['encoding'])) {
            $this->encoding = $options['encoding'];
        }
        
        if (isset($options['cache_dir'])) {
            $this->cacheDir = $options['cache_dir'];
        }
    }
    
    /**
     * @api
     * 
     * @param string $key 
     * @param mixed $value 
     * 
     * @return File Provides a fluent interface.
     */
    public function set($key, $value)
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
        file_put_contents($filename, $data);
        
        return $this;
    }
    
    /**
     * @api
     * 
     * @param string $key 
     * 
     * @return mixed
     */
    public function get($key)
    {
        $filename = $this->prepareFilename($key);
        $filename = realpath($filename);
        
        if (!$filename) {
            return null;
        }
        
        $data = file_get_contents($filename, 'r');
               
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
     * @param string $filename 
     * 
     * @return string
     */
    protected function prepareFilename($filename)
    {
        if (isset($this->cacheDir)) {
            $filename = $this->cacheDir . DIRECTORY_SEPARATOR . $filename;
        }

        return $filename;        
    }
}