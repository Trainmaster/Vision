<?php
namespace Vision\DependencyInjection;

use ReflectionClass;
use RuntimeException;
use InvalidArgumentException;

class Container extends Config\AbstractConfig implements ContainerInterface
{
    /**
     * @param void
     */
    public function __construct()
    {
        $this->objects['dic'] = $this;
    }
    
    /**
     * @type array $objects
     */
    protected $objects = array();
    
    /**
     * @param string $alias 
     * 
     * @return bool
     */
    public function isDefined($alias)
    {
        if (isset($this->definitions[$alias])) {
            return true;
        }
        return false;
    }
    
    /**
     * @param string $alias 
     * 
     * @return mixed
     */
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
        } else {
            throw new RuntimeException(sprintf(
                'No definition for "%s". Please double-check the container configuration file(s).', 
                $alias
            ));
        }
    }
    
    /**
     * @param Definition $definition 
     * 
     * @return mixed
     */
    protected function createObject(Definition $definition)
    {                   
        $reflection = new ReflectionClass($definition->getClass());
        
        if ($reflection->isInstantiable() === false) {
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
            foreach ($propertyInjections as $property => $value) {
                $reflection->getProperty($property)->setValue($instance, $this->resolveDependency($value));
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
    
    /**
     * @param string $dependency 
     * 
     * @return mixed
     */
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
    
    /**
     * @param array $dependencies 
     * 
     * @return array
     */
    protected function resolveDependencies(array $dependencies)
    {
        foreach ($dependencies as &$dependency) {
            $dependency = $this->resolveDependency($dependency);
        }     
        return $dependencies;
    }

    /**
     * @param string $dependency 
     * 
     * @return mixed
     */
    protected function resolveReference($dependency)
    {        
        if (strpos($dependency, '@') === 0) {
            $dependency = substr($dependency, 1);
            return $this->get($dependency);
        }
        return $dependency;
    }
}