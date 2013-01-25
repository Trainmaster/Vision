<?php
namespace Vision\DependencyInjection;

use Vision\DependencyInjection\Dependency;

class Definition 
{	
	private $class = null;
	
	private $dependencies = array();
    
    private $shared = true;
	
	public function __construct($class) 
    {
		$this->class = (string) $class;
	}
	
	public function constructor(array $constructor) 
    {
		$this->addDependency($constructor, Dependency::INJECTION_METHOD_CONSTRUCTOR);
		return $this;
	}

	public function setter(array $setter) 
    {
		$this->addDependency($setter, Dependency::INJECTION_METHOD_SETTER);
		return $this;
	}
	
	public function property(array $property) 
    {
		$this->addDependency($property, Dependency::INJECTION_METHOD_PROPERTY);
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
    
    public function setShared($shared) 
    {
        $this->shared = (bool) $shared;
        return $this;
    }
    
    public function isShared() 
    {
        return $this->shared;
    }
	
	private function addDependency(array $dependencies, $injectionMethod) 
    {
		foreach ($dependencies as $name => $dependency) {
			if (is_string($dependency)) {
				$dependency = trim($dependency);
				if (strpos($dependency, '@') === 0) {
					$type = Dependency::TYPE_OBJECT;
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
											 ->setInjectionMethod($injectionMethod)
											 ->setName($name);
		}
	}
}