<?php
namespace Vision\DependencyInjection;

use Vision\DependencyInjection\Dependency;
use InvalidArgumentException;

class Definition 
{
    protected $class = null;
    
    protected $shared = true;
    
    protected $constructor = array();
    
    protected $property = array();
    
    protected $setter = array();
        
    public function __construct($class)
    {
        $this->class = $class;
    }
    
    public function getClass() 
    {
        return $this->class;
    }
    
    public function setShared($shared)
    {
        $this->shared = (bool) $shared;
        return $this;
    }
    
    public function isShared()
    {
        return $this->shared;
    }
    
    public function constructor(array $constructor) 
    {   
        $this->constructor = $constructor;
        return $this;
    }
    
    public function property($property, array $dependencies) 
    {
        if (is_string($property) === false) {
            throw new InvalidArgumentException(sprintf(
                'Argument 1 passed to %s must be a string.',
                __METHOD__
            ));
        }
        $this->property[][$property] = $dependencies;
        return $this;
    }
    
    public function setter($setter, array $dependencies) 
    {
        if (is_string($setter) === false) {
            throw new InvalidArgumentException(sprintf(
                'Argument 1 passed to %s must be a string.',
                __METHOD__
            ));
        }
        $this->setter[][$setter] = $dependencies;
        return $this;
    } 
    
    public function setSetter(array $setter)
    {
        $this->setter = $setter;
        return $this;
    }
    
    public function getConstructorInjections() 
    {   
        return $this->constructor;
    }
    
    public function getPropertyInjections() 
    {
        return $this->property;
    }
    
    public function getSetterInjections() 
    {
        return $this->setter;
    } 
}