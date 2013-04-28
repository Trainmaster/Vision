<?php
namespace Vision\DependencyInjection\Config;

use Vision\DependencyInjection\Definition;

abstract class AbstractConfig
{
    protected $definitions = array();
    
    protected $parameters = array();
    
    public function addDefinition($alias, Definition $definition) 
    {           
        $class = $this->resolveParameter($definition->getClass());
        $definition->setClass($class);        
        if ($alias !== null) {
            $this->definitions[$this->resolveParameter($alias)] = $definition;
        } else {
            $this->definitions[$class] = $definition;
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
    
    public function getDefinitions()
    {
        return $this->definitions;
    }
    
    public function addParameter($key, $value)
    {
        $this->parameters[$key] = $this->resolveParameter($value);
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
    
    public function getParameters()
    {
        return $this->parameters;
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
}