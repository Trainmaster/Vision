<?php
namespace Vision\View;

interface ViewInterface 
{
    public function __set($key, $value);
    
    public function __get($key);
    
    public function __toString();
}