<?php
namespace Vision\View;

class AbstractView implements ViewInterface
{
    protected $vars = array();
    
    public function __set($key, $value) 
    {
        $this->vars[$key] = $value;
        return $this;    
    }
    
    public function __get($key)
    {
        if (isset($this->vars[$key])) {
            return $this->vars[$key];
        }
        return null;
    }
    
    public function __toString()
    {
        return implode(' ', $this->vars);
    }
}