<?php
namespace Vision\DependencyInjection;

use Vision\DependencyInjection\Dependency;

class Definition 
{
    private $class = null;
    
    private $dependencies = array();
    
    public function __construct($class)
    {
        $this->class = (string) $class;
    }
    
    public function constructor(array $constructor)
    {
        $this->resolveDependency($constructor, Dependency::METHOD_CONSTRUCTOR);
        return $this;
    }
    
    public function setter(array $setter)
    {
		$this->resolveDependency($setter, Dependency::METHOD_SETTER);
		return $this;
	}
    
    public function property(array $property)
    {
        $this->resolveDependency($property, Dependency::METHOD_PROPERTY);
        return $this;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getDependencies()
    {
        return $this->dependencies;
    }

    private function resolveDependency(array $dependencies, $method) 
    {
        foreach ($dependencies as $name => $dependency) {
            if (is_string($dependency)) {
                $dependency = trim($dependency);
                if (strpos($dependency, '@') === 0) {
                    $type = Dependency::TYPE_SERVICE;
                    $value = substr($dependency, 1);
                } elseif (strpos($dependency, '%') === 0) {		
                    $type = Dependency::TYPE_PARAMETER;
                    $value = substr($dependency, 1);
                }  else {
                    $type = Dependency::TYPE_VALUE;
                    $value = $dependency;
                }
            } elseif (is_array($dependency)) {
                $type = Dependency::TYPE_VALUE;
                $value = $dependency;
            }
            $instance = new Dependency;
            $this->dependencies[] = $instance->setType($type)
                                             ->setValue($value)
                                             ->setMethod($method)
                                             ->setName($name);
        }
    }
}