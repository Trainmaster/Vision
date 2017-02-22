<?php
declare(strict_types=1);

namespace Vision\DependencyInjection;

use ReflectionClass;

class Container implements ContainerInterface
{
    /** @var Definition[] $definitions */
    protected $definitions = [];

    /** @var array $parameters */
    protected $parameters = [];

    /** @var array $objects */
    protected $objects = [];

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
    public function register(string $class, $alias = null): Definition
    {
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
            throw new AliasReservedException(sprintf(
                'The alias "%s" is reserved.',
                $alias
            ));
        }

        if ($this->has($alias)) {
            throw new AliasAlreadyRegisteredException(sprintf(
                'The alias "%s" is already registered with class "%s".',
                $alias,
                $this->definitions[$alias]->getClass()
            ));
        }

        $this->definitions[$alias] = $definition;

        return $definition;
    }

    public function getDefinition(string $alias)
    {
        return $this->definitions[$alias] ?? null;
    }

    public function getDefinitions(): array
    {
        return $this->definitions;
    }

    public function setParameter(string $key, $value): Container
    {
        $this->parameters[$key] = $this->resolveParameter($value);
        return $this;
    }

    public function setParameters(array $parameters): Container
    {
        foreach ($parameters as $key => $value) {
            $this->setParameter($key, $value);
        }

        return $this;
    }

    public function getParameter(string $key)
    {
        return $this->parameters[$key] ?? null;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function get(string $alias)
    {
        if ($alias === 'self') {
            return $this;
        }

        if (!$this->has($alias)) {
            throw new NotFoundException(sprintf(
                'No definition for "%s". Double-check the container configuration file(s).',
                $alias
            ));
        }

        $definition = $this->getDefinition($alias);

        if ($definition->isShared()) {
            return $this->createSharedInstance($alias, $definition);
        }

        return $this->createInstance($definition);
    }

    public function has(string $alias): bool
    {
        return isset($this->definitions[$alias]);
    }

    private function createSharedInstance(string $alias, Definition $definition)
    {
        return isset($this->objects[$alias])
            ? $this->objects[$alias]
            : $this->objects[$alias] = $this->createInstance($definition);
    }

    private function createInstance(Definition $definition)
    {
        if ($definition->hasFactory()) {
            return $this->createInstanceFromFactory($definition);
        }

        $reflection = new ReflectionClass($definition->getClass());

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

        if ($reflection->getConstructor()) {
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

    private function createInstanceFromFactory(Definition $definition)
    {
        $factory = $definition->getFactory();
        $dependency = $this->resolveDependency($factory[0]);

        return $factory[2]
            ? call_user_func_array([$dependency, $factory[1]], $this->resolveDependencies($factory[2]))
            : call_user_func([$dependency, $factory[1]]);
    }

    private function resolveDependency($dependency)
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

    private function resolveDependencies(array $dependencies): array
    {
        foreach ($dependencies as &$dependency) {
            $dependency = $this->resolveDependency($dependency);
        }

        return $dependencies;
    }

    /**
     * @todo Compiler for caching.
     * @todo Support for other parameter types (currently, only string is supported)
     */
    private function resolveParameter(string $dependency)
    {
        $i = substr_count($dependency, '%');

        if ($i % 2 === 0 && $i >= 2) {
            $value = preg_replace_callback("#%([\w.-]+)%#u", function($match) {
                $parameter = $this->getParameter($match[1]);
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

    private function resolveReference(string $dependency)
    {
        if (strpos($dependency, '@') === 0) {
            $dependency = substr($dependency, 1);
            return $this->get($dependency);
        }

        return $dependency;
    }
}
