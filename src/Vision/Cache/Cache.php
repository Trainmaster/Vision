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
class Cache
{
    /**
     * @param Adapter\AdapterInterface $adapter 
     */
    public function __construct(Adapter\AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return Adapter\AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
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
        return $this->adapter->set($key, $value);
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
        return $this->adapter->get($key);
    }
}