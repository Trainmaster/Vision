<?php
namespace Vision\DependencyInjection;

use ReflectionClass;
use RuntimeException;
use InvalidArgumentException;

class Container extends Config\AbstractConfig implements ContainerInterface
{    
    protected $objects = array();
    
    public function isDefined($alias)
    {
        if (isset($this->definitions[$alias])) {
            return true;
        } else {
            throw new RuntimeException(sprintf(
                'No definition for "%s". Please check the container configuration.', 
                $alias
            ));
        }
    }
    
    public function get($alias)
    {
        if ($this->isDefined($alias)) {
            $definition = $this->definitions[$alias];
            $isShared = $definition->isShared();
            if ($isShared && isset($this->objects[$alias])) {
                return $this->objects[$alias];
            } elseif ($isShared === false) {
                return $this->createObject($definition);
            } else {
                $instance = $this->createObject($definition);
                $this->objects[$alias] = $instance;
                return $instance;
            }
        }
    }
    
    protected function createObject(Definition $definition)
    {	                
        $reflection = new ReflectionClass($this->resolveDependency($definition->getClass()));
        
        if ($reflection->isInterface() || $reflection->isAbstract()) {
            return false;
        }

        $constructorInjections = $definition->getConstructorInjections();
        if (!empty($constructorInjections)) {
            $instance = $reflection->newInstanceArgs($this->resolveDependencies($constructorInjections));
        } else {
            $instance = $reflection->newInstance();
        }

        $propertyInjections = $definition->getPropertyInjections();
        if (!empty($propertyInjections)) {
            foreach ($propertyInjections as $property) {
                foreach ($property as $propertyName => $dependencies) {
                    $reflection->getProperty($propertyName)->setValue($instance, $this->resolveDependencies($dependencies));
                }
            }
        }
        
        $setterInjections = $definition->getSetterInjections();
        if (!empty($setterInjections)) {	
            foreach ($setterInjections as $setter) {
                foreach ($setter as $method => $dependencies) {
                    $reflection->getMethod($method)->invokeArgs($instance, $this->resolveDependencies($dependencies));
                }
            }				
        }	
        
        return $instance;		
    }
    
    protected function resolveDependency($dependency)
    {    
        if (is_string($dependency)) {
            $dependency = $this->resolveParameter($dependency);
            $dependency = $this->resolveReference($dependency);    
        } elseif (is_array($dependency)) {
            foreach ($dependency as &$value) {
                $value = $this->resolveDependency($value);
            }
        }        
        return $dependency;
    }
    
    protected function resolveDependencies(array $dependencies)
    {
        foreach ($dependencies as &$dependency) {
            $dependency = $this->resolveDependency($dependency);
        }     
        return $dependencies;
    }   
}