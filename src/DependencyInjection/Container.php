<?php
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
    /** @var array|Definition[] $definitions */
    protected $definitions = [];

    /** @var array $parameters */
    protected $parameters = [];

    /** @var array $objects */
    protected $objects = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->objects['dic'] = $this;
    }

    /**
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
                'The alias "%s" is already assigned to the class "%s".',
                $alias,
                $this->definitions[$alias]->getClass()
            ));
        }

        $this->definitions[$alias] = $definition;

        return $definition;
    }

    /**
     * @param string $alias
     *
     * @return mixed
     */
    public function getDefinition($alias)
    {
        return isset($this->definitions[$alias]) ? $this->definitions[$alias] : null;
    }

    /**
     * @return array
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
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
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
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

        $definition = $this->getDefinition($alias);

        if ($definition) {
            return $definition->isShared()
                ? $this->createSharedInstance($alias, $definition)
                : $this->createInstance($definition);
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
     * @param string $alias
     * @param Definition $definition
     *
     * @return mixed
     */
    private function createSharedInstance($alias, Definition $definition)
    {
        return isset($this->objects[$alias])
            ? $this->objects[$alias]
            : $this->objects[$alias] = $this->createInstance($definition);
    }

    /**
     * @param Definition $definition
     *
     * @return mixed
     */
    protected function createInstance(Definition $definition)
    {
        $class = $definition->getClass();
        $factory = $definition->getFactory();

        if ($factory) {
            $dependency = $this->resolveDependency($factory[0]);

            return $factory[2]
                ? call_user_func_array([$dependency, $factory[1]], $this->resolveDependencies($factory[2]))
                : call_user_func([$dependency, $factory[1]]);
        }

        $reflection = new ReflectionClass($class);

        if (!$reflection->isInstantiable()) {
            return false;
        }

        $interfaces = $reflection->getInterfaceNames();

        if (!empty($interfaces)) {
            $methodInjections = [];
            foreach ($interfaces as $interface) {
                $interfaceDefinition = $this->getDefinition($interface);

                if (!$interfaceDefinition) {
                    continue;
                }

                $dependencies = $interfaceDefinition->getMethodInjections();

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
     * @param string|array $dependency
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
