<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Cache;

/**
 * Cache
 *
 * @author Frank Liepert
 */
class Cache implements CacheInterface
{
    /**
     * @param Storage\StorageInterface $storage 
     */
    public function __construct(Storage\StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return Adapter\AdapterInterface
     */
    public function getAdapter()
    {
        return $this->storage;
    }
    
    /**
     * @api
     * 
     * @param string $key 
     * @param mixed $value 
     * 
     * @return Adapter\AdapterInterface Provides a fluent interface.
     */
    public function set($key, $value)
    {
        return $this->storage->set($key, $value);
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
        return $this->storage->get($key);
    }
}