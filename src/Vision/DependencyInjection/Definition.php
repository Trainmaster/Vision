<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\DependencyInjection;

/**
 * Definition
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Definition
{
    /** @var mixed $class */
    protected $class;

    /** @var bool $shared */
    protected $shared = true;

    /** @var bool|array $factory */
    protected $factory = false;

    /** @var array $property */
    protected $property = [];

    /** @var array $constructor */
    protected $constructor = [];

    /** @var array $method */
    protected $method = [];

    /**
     * @param string $class
     */
    public function __construct($class)
    {
        $this->setClass($class);
    }

    /**
     * @param string $class
     *
     * @throws \InvalidArgumentException
     *
     * @return $this Provides a fluent interface.
     */
    public function setClass($class)
    {
        if (!is_string($class)) {
            throw new \InvalidArgumentException(sprintf(
                'Argument 1 passed to %s must be a string.',
                __METHOD__
            ));
        }
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param bool $shared
     *
     * @return $this Provides a fluent interface.
     */
    public function setShared($shared)
    {
        $this->shared = (bool) $shared;
        return $this;
    }

    /**
     * @return bool
     */
    public function isShared()
    {
        return $this->shared;
    }

    /**
     * @param string $property
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     *
     * @return $this Provides a fluent interface.
     */
    public function property($property, $value)
    {
        if (!is_string($property)) {
            throw new \InvalidArgumentException(sprintf(
                'Argument 1 passed to %s must be a string.',
                __METHOD__
            ));
        }
        $this->property[$property] = $value;
        return $this;
    }

    /**
     * @param array $constructor
     *
     * @return $this Provides a fluent interface.
     */
    public function constructor(array $constructor)
    {
        $this->constructor = $constructor;
        return $this;
    }

    /**
     * @param string $method
     * @param array $dependencies
     *
     * @throws \InvalidArgumentException
     *
     * @return $this Provides a fluent interface.
     */
    public function method($method, array $dependencies)
    {
        if (!is_string($method)) {
            throw new \InvalidArgumentException(sprintf(
                'Argument 1 passed to %s must be a string.',
                __METHOD__
            ));
        }
        $this->method[][$method] = $dependencies;
        return $this;
    }

    /**
     * @param string $dependency
     * @param string $method
     * @param array  $args
     *
     * @return $this Provides a fluent interface.
     */
    public function factory($dependency, $method, array $args = [])
    {
        $this->factory = [(string) $dependency, (string) $method, $args];
        return $this;
    }

    /**
     * @return bool|array
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param array $method
     *
     * @return $this Provides a fluent interface.
     */
    public function setMethod(array $method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return array
     */
    public function getPropertyInjections()
    {
        return $this->property;
    }

    /**
     * @return array
     */
    public function getConstructorInjections()
    {
        return $this->constructor;
    }

    /**
     * @return array
     */
    public function getMethodInjections()
    {
        return $this->method;
    }
}
