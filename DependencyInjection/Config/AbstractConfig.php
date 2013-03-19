<?php
namespace Vision\DependencyInjection\Config;

use Vision\DependencyInjection\Definition;

abstract class AbstractConfig
{
    protected $definitions = array();
    
    protected $parameters = array();
    
    public function addDefinition($alias, Definition $definition) 
    {	        
        if ($alias !== null) {
            $this->definitions[$this->resolveParameter($alias)] = $definition;
        } else {
            $this->definitions[$this->resolveParameter($definition->getClass())] = $definition;
        }
        return $definition;
    }
    
    public function getDefinition($alias)
    {
        if (isset($this->definitions[$alias])) {
            return $this->definitions[$alias];
        }
        return null;
    }
    
    public function addParameter($key, $value)
    {
        $this->parameters[$key] = $value;
        return $this;
    }
    
    public function addParameters(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            $this->addParameter($key, $value);
        }
        return $this;
    }
    
    public function getParameter($key)
    {
        if (isset($this->parameters[$key])) {
            return $this->parameters[$key];
        }
        return null;
    }
    
    protected function resolveParameter($dependency)
    {
        $i = substr_count($dependency, '%');        
        if ($i >= 2 && $i % 2 === 0) {		
            $di = $this;
            $dependency = preg_replace_callback("#%([\w.-]+)%#", function($match) use (&$di) {
                return $di->getParameter($match[1]) !== null ? $di->getParameter($match[1]) : $match[1];
            }, $dependency);            
        }
        return $dependency;
    }
    
    protected function resolveReference($dependency)
    {
        
        if (strpos($dependency, '@') === 0) {
            $dependency = substr($dependency, 1);
            return $this->get($dependency);
        }
        return $dependency;
    }
}