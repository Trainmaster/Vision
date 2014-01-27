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
     * @param string $class
     * @param null|string $alias
     *
     * @throws \InvalidArgumentException
     * @throws \LogicException
     *
     * @return Definition
     */
    public function register($class, $alias = null)
    {
        if (!is_string($class)) {
            throw new \InvalidArgumentException(sprintf(
                'Argument 1 passed to %s must be a string.',
                __METHOD__
            ));
        }

        $class = $this->resolveParameter($class);
        $definition = new Definition($class);

        if (!isset($alias)) {
            $alias = $class;
        }

        if (!is_string($alias)) {
            throw new \InvalidArgumentException(sprintf(
                'Argument 2 passed to %s must be a string.',
                __METHOD__
            ));
        }

        if ($alias === 'self') {
            throw new \LogicException(sprintf(
                'The alias "%s" is reserved.',
                $alias
            ));
        }

        if (isset($this->definitions[$alias])) {
            throw new \LogicException(sprintf(
                'The alias "%s" is already assigned.',
                $alias
            ));
        }

        $this->definitions[$alias] = $definition;

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
    public function setParameter($key, $value)
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
    public function setParameters(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            $this->setParameter($key, $value);
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
        return isset($this->definitions[$alias]);
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
        } elseif($alias === 'self') {
            return $this;
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
        $class = $definition->getClass();
        $reflection = new ReflectionClass($class);

        if (!$reflection->isInstantiable()) {
            return false;
        }

        $interfaces = $reflection->getInterfaceNames();

        if (!empty($interfaces)) {
            $methodInjections = array();
            foreach ($interfaces as $interface) {
                if (!$this->isDefined($interface)) {
                    continue;
                }

                $def = $this->getDefinition($interface);

                $dependencies = $def->getMethodInjections();

                if (empty($dependencies)) {
                    continue;
                }

                $methodInjections = array_merge($methodInjections, $dependencies);
            }

            if (!empty($methodInjections)) {
                foreach ($methodInjections as $method) {
                    foreach ($method as $name => $args) {
                        $definition->method($name, $args);
                    }
                }
            }
        }

        $constructor = $reflection->getConstructor();

        if ($constructor) {
            $constructorInjections = $definition->getConstructorInjections();

            // number of required parameters causes trouble when working with certain PDO

            /*
            $required = $constructor->getNumberOfRequiredParameters();
            $given = count($constructorInjections);

            if ($given < $required) {
                throw new \RuntimeException(sprintf(
                    'The class "%s" requires %s arguments, %s given.',
                    $class,
                    $required,
                    $given
                ));
            }
            */

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

        $methodInjections = $definition->getMethodInjections();
        if (!empty($methodInjections)) {
            foreach ($methodInjections as $methods) {
                foreach ($methods as $method => $dependencies) {
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
                $parameter = $di->getParameter($match[1]);
                if ($parameter !== null) {
                    return $parameter;
                } else {
                    throw new \OutOfRangeException(sprintf(
                        'No parameter definition for "%s". Double-check the container configuration file(s).',
                        $match[1]
                    ));
                }
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
