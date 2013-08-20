<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\DependencyInjection;

use InvalidArgumentException;
use ReflectionClass;
use RuntimeException;

/**
 * Container
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Container implements ContainerInterface
{    
    /** @type array $definitions */
    protected $definitions = array();
    
    /** @type array $parameters */
    protected $parameters = array();
    
    /** @type array $objects */
    protected $objects = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->objects['dic'] = $this;
    }
    
    /**
     * @api
     * 
     * @param string $alias 
     * @param Definition $definition 
     * 
     * @return Definition
     */
    public function addDefinition($alias, Definition $definition) 
    {           
        $class = $definition->getClass();
        $class = $this->resolveParameter($class);
        
        $definition->setClass($class);
        $this->definitions[$class] = $definition;
        
        if ($alias !== null) {
            $this->definitions[$this->resolveParameter($alias)] =& $this->definitions[$class];
        }
        
        return $definition;
    }
    
    /**
     * @api
     * 
     * @param string $alias 
     * 
     * @return mixed
     */
    public function getDefinition($alias)
    {
        if (isset($this->definitions[$alias])) {
            return $this->definitions[$alias];
        }
        
        return null;
    }
    
    /**
     * @api
     * 
     * @return array
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }
    
    /**
     * @api
     * 
     * @param string $key 
     * @param mixed $value 
     * 
     * @return Container Provides a fluent interface.
     */
    public function addParameter($key, $value)
    {
        if (!is_string($key)) {
            throw new InvalidArgumentException(sprintf(
                'Argument 1 passed to %s must be a string.',
                __METHOD__
            ));
        }
        
        $this->parameters[$key] = $this->resolveParameter($value);
        
        return $this;
    }
    
    /**
     * @api
     * 
     * @param array $parameters 
     * 
     * @return Container Provides a fluent interface.
     */
    public function addParameters(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            $this->addParameter($key, $value);
        }
        
        return $this;
    }
    
    /**
     * @api
     * 
     * @param string $key 
     * 
     * @return mixed
     */
    public function getParameter($key)
    {
        if (isset($this->parameters[$key])) {
            return $this->parameters[$key];
        }
        
        return null;
    }
    
    /**
     * @api
     * 
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
    
    /**
     * @api
     *
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
     * @api
     *
     * @param string $alias 
     * 
     * @return object
     *
     * @throws RuntimeException
     */
    public function get($alias)
    {
        if (!is_string($alias)) {
            throw new InvalidArgumentException(sprintf(
                'Argument 1 passed to %s must be a string.',
                __METHOD__
            ));
        }
        
        if ($this->isDefined($alias)) {
            $definition = $this->definitions[$alias];
            $isShared = $definition->isShared();
            if ($isShared && isset($this->objects[$alias])) {
                return $this->objects[$alias];
            } elseif (!$isShared) {
                return $this->createObject($definition);
            } else {
                $instance = $this->createObject($definition);
                $this->objects[$alias] = $instance;
                return $instance;
            }
        } else {
            throw new RuntimeException(sprintf(
                'No definition for %s. Double-check the container configuration file(s).', 
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
        
        if (!$reflection->isInstantiable()) {
            return false;
        }
        
        $interfaces = $reflection->getInterfaceNames();
        
        if (!empty($interfaces)) {
            $setterInjections = array();
            foreach ($interfaces as $interface) {            
                if (!$this->isDefined($interface)) {
                    continue;
                }

                $def = $this->getDefinition($interface);
                
                $dependencies = $def->getSetterInjections();
                
                if (empty($dependencies)) {
                    continue;
                }     
                
                $setterInjections = array_merge($setterInjections, $dependencies);                
            }
            
            if (!empty($setterInjections)) {
                $definition->setSetter($setterInjections); 
            }
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
     * @todo Compiler for caching.
     * @todo Support for other parameter types (currently, only string is supported)
     *
     * @param string $dependency 
     * 
     * @return mixed
     */
    protected function resolveParameter($dependency)
    {              
        $i = substr_count($dependency, '%');
       
        if ($i % 2 === 0 && $i >= 2) {      
            $di = $this;
            $value = preg_replace_callback("#%([\w.-]+)%#u", function($match) use (&$di) {
                return $di->getParameter($match[1]) !== null ? $di->getParameter($match[1]) : $match[1];
            }, $dependency);
            $dependency = $value;
        }
        
        return $dependency;
    } 
    
    /**
     * @param string $dependency 
     * 
     * @return mixed
     */
    protected function resolveReference($dependency)
    {
        if (is_string($dependency) && strpos($dependency, '@') === 0) {
            $dependency = substr($dependency, 1);
            return $this->get($dependency);
        }
        
        return $dependency;
    }
}