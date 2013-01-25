<?php
namespace Vision\DependencyInjection;

class Dependency 
{
    const TYPE_OBJECT = 1;
    
    const TYPE_PARAMETER = 2;
    
    const TYPE_VALUE = 3;
    
    const INJECTION_METHOD_CONSTRUCTOR = 4;
    
    const INJECTION_METHOD_SETTER = 5;
    
    const INJECTION_METHOD_PROPERTY = 6;

    private $type = null;

    private $value = null;

    private $injectionMethod = null;

    private $name = null;

    public function setType($type) 
    {			
        $this->type = (int) $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setValue($value) 
    {
        $this->value = $value;
        return $this;
    }	

    public function getValue() 
    {
        return $this->value;
    }

    public function setInjectionMethod($injectionMethod) 
    {			
        $this->injectionMethod = (int) $injectionMethod;
        return $this;
    }

    public function getInjectionMethod() 
    {
        return $this->injectionMethod;
    }

    public function setName($name) 
    {
        $this->name = (string) $name;
        return $this;
    }

    public function getName() 
    {
        return $this->name;
    }
}