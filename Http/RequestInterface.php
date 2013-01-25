<?php
namespace Vision\Http;

interface RequestInterface
{
    public function __construct();
    
    public function __set($key, $value);
    
    public function __get($key);
    
    public function getMethod();   
}