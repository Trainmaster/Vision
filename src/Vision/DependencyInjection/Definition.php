<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\DependencyInjection;

use Vision\DependencyInjection\Dependency;

/**
 * Definition
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Definition
{
    /** @type mixed $class */
    protected $class;

    /** @type bool $shared */
    protected $shared = true;

    /** @type array $property */
    protected $property = array();

    /** @type array $constructor */
    protected $constructor = array();

    /** @type array $method */
    protected $method = array();

    /**
     * @param string $class
     */
    public function __construct($class)
    {
        $this->setClass($class);
    }

    /**
     * @api
     *
     * @param string $class
     *
     * @throws InvalidArgumentException
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
     * @api
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @api
     *
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
     * @api
     *
     * @return bool
     */
    public function isShared()
    {
        return $this->shared;
    }

    /**
     * @api
     *
     * @param string $property
     * @param mixed $value
     *
     * @throws InvalidArgumentException
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
     * @api
     *
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
     * @api
     *
     * @param string $method
     * @param array $dependencies
     *
     * @throws InvalidArgumentException
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
     * @api
     *
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
     * @api
     *
     * @return array
     */
    public function getPropertyInjections()
    {
        return $this->property;
    }

    /**
     * @api
     *
     * @return array
     */
    public function getConstructorInjections()
    {
        return $this->constructor;
    }

    /**
     * @api
     *
     * @return array
     */
    public function getMethodInjections()
    {
        return $this->method;
    }
}
