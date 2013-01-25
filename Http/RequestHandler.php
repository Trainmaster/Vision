<?php
namespace Vision\Http;

class RequestHandler {

    private $data = array();

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