<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Http;

/**
 * RequestHandler
 *
 * @author Frank Liepert
 */
class RequestHandler
{
    protected $data = array();

    public function __construct (array $data)
    {
        $this->data = $data;
    }
    
    public function add($key, $value, $replace = false)
    {
        if ($replace === false || !isset($this->data[$key])) {
            $this->data[$key] = $value;
        }
        return $this;
    }
    
    public function get($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
        return null;
    }
    
    public function getAll()
    {
        return $this->data;
    }
    
    public function hasKey($key)
    {
        if (array_key_exists($key, $this->data)) {
            return true;
        }
        return false;
    }
}