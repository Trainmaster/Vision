<?php
namespace Vision\DependencyInjection;

use Vision\DependencyInjection\ContainerConfig;
use Vision\DependencyInjection\ContainerDefinition;

class ContainerException extends \Exception {}

class Container 
{
    private $resources = array();
    
    private $parameters = array();
    
    private $definitions = array();
    
    private $objects = array();
    
    public function __construct($loader, $resource)
    {
        $this->loader = $loader;
        $this->addConfiguration($resource);
    }
    
    public function addConfiguration($resource)
    {
        $config = $this->loader->load($resource);
        if ($config instanceof ContainerConfig) {
            if ($config->getParameters()) {
                $this->mergeParameters($config->getParameters());
            }
            if ($config->getDefinitions()) {
                $this->mergeDefinitions($config->getDefinitions());
            }
            if ($config->getResources()) {
                $this->mergeResources($config->getResources());
            }
            $this->resources[] = $resource;
            $config = null;
        } else {
            throw new ContainerException(sprintf(
                'The configuration file "%s" must return an instance of "%s".', 
                $resource, 'Vision\DependencyInjection\ContainerConfig')
            );
        }		
        return $this;
	}
    
    public function mergeParameters(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            if (isset($this->parameters[$key])) {
                throw new ContainerException(sprintf('Parameter "%s" is already defined.', $key));
            } 
            $this->parameters[$key] = $value;
        }	
        return true;
    }
    
    public function mergeDefinitions(array $definitions)
    {
        foreach ($definitions as $key => $value) {
            if (isset($this->definitions[$key])) {
                throw new ContainerException(sprintf('Definition "%s" is already defined.', $key));
            } 
            $this->definitions[$key] = $value;
        }	
        return true;
    }
    
    public function mergeResources(array $resources)
    {
        foreach ($resources as $value) {
            if (in_array($value, $this->resources, true)) {
                throw new ContainerException(sprintf('Resource "%s" is already defined.', $key));
            } 
                $this->addConfiguration($value);
            }	
        return true;
    }
    
    public function getResources() 
    {
        return $this->resources;
    }
    
    public function addParameter($key, $value)
    {
        if (isset($this->parameters[$key])) {
            throw new ContainerException(sprintf('Parameter "%s" does already exist.', $key));
        } else {
            $this->parameters[$key] = $value;
        }
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
    
    public function addDefinition($key, $value)
    {
        if (isset($this->definitions[$key])) {
            throw new ContainerException(sprintf('Definition "%s" does already exist.', $key));
        } else {
            $this->definitions[$key] = $value;
        }
        return $this;
    }
    
    public function addDefinitions(array $definitions)
    {
        foreach ($definitions as $key => $value) {
            $this->addDefinition($key, $value);
        }		
        return $this;
    }
    
    public function set($id, $object)
    {
        if (isset($this->objects[$key])) {
            throw new ContainerException(sprintf('Service "%s" does already exist.', $id));
        } else {
            $this->objects[$id] = $object;
        }
        return $this;
    }
    
    public function get($id)
    {			
        if (isset($this->objects[$id])) {
            return $this->objects[$id];
        } 			
        return $this->createObject($id);
    }
    
    public function getAll()
    {
        return $this->objects;
    }
    
    private function createObject($id)
    {			
        if (isset($this->definitions[$id])) {
            $definition = $this->definitions[$id];
            $reflection = new \ReflectionClass($definition->getClass());
            $dependencies = $definition->getDependencies();
            if (!empty($dependencies)) {
                $args = array();
                foreach ($dependencies as $dependency) {
                    $type = $dependency->getType();

                    switch ($type) {
                        case Dependency::TYPE_OBJECT:
                        $value = $this->createObject($dependency->getValue());
                        break;

                        case Dependency::TYPE_PARAMETER:
                        $value = $this->getParameter($dependency->getValue());
                        break;

                        case Dependency::TYPE_VALUE:
                        $value = $dependency->getValue();
                        break;	
                    }

                    $method = $dependency->getInjectionMethod();

                    switch ($method) {
                        case Dependency::INJECTION_METHOD_CONSTRUCTOR:
                        $args['constructor'][] = $value;
                        break;

                        case Dependency::INJECTION_METHOD_SETTER:
                        $args['setter'][$dependency->getName()] = $value;
                        break;

                        case Dependency::INJECTION_METHOD_PROPERTY:
                        $args['property'][$dependency->getName()] = $value;
                        break;
                    }
                }			
            }		
        } else {
            throw new ContainerException(sprintf('Service "%s" is not defined.', $id));
        }		

        if (isset($args['constructor'])) {
            $instance = $reflection->newInstanceArgs($args['constructor']);
        } else {
            $instance = $reflection->newInstance();
        }

        if (isset($args['property'])) {
            foreach ($args['property'] as $key => $value) {
                $reflection->getProperty($key)->setValue($instance, $value);
            }
        }

        if (isset($args['setter'])) {	
            foreach ($args['setter'] as $key => $value) {
                $reflection->getMethod($key)->invokeArgs($instance, $value);
            }				
        }	

        $this->objects[$id] = $instance;

        return $instance;		
    }
}