<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Routing;

abstract class AbstractCompiledRoute extends AbstractRoute
{
    /** @var null|string $class */
    protected $class;

    /** @var null|string $method */
    protected $method;

    /**
     * @param string $class
     *
     * @return $this Provides a fluent interface.
     */
    public function setClass($class)
    {
        $this->class = trim($class);
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
     * @param string $method
     *
     * @return $this Provides a fluent interface.
     */
    public function setMethod($method)
    {
        $this->method = trim($method);
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
}
