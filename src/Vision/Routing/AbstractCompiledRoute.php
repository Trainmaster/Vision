<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Routing;

/**
 * AbstractCompiledRoute
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
abstract class AbstractCompiledRoute extends AbstractRoute
{
    /** @type null|string $class */
    protected $class = null;
    
    /** @type null|string $method */
    protected $method = null;
    
    /**
     * @api
     *
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
     * @api 
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
    
    /**
     * @api
     * 
     * @return string
     */
    public function getHttpMethod()
    {
        return isset($this->requirements['HTTP_METHOD']) ? $this->requirements['HTTP_METHOD'] : null;
    }
}