<?php
namespace Vision\DependencyInjection;

use Vision\DependencyInjection\Dependency;

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
        if (empty($this->constructor)) {
            $this->constructor = $constructor;
        } else {
            $this->constructor = $this->constructor + $constructor;
        }
        return $this;
    }
    
    public function property(array $property) 
    {
        if (empty($this->property)) {
            $this->property = $property;
        } else {
            $this->property = $this->property + $property;
        }
        return $this;
    }
    
    public function setter(array $setter) 
    {
        if (empty($this->setter)) {
            $this->setter = $setter;
        } else {
            $this->setter = $this->setter + $setter;
        }
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