<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Routing;

class Route extends AbstractRoute
{
    /** @var array $httpMethod */
    protected $httpMethod = [];

    /** @var null|string $controller */
    protected $controller = null;

    /** @var null|string $path */
    protected $path = null;

    /**
     * @param string|array $httpMethod
     * @param string $path
     * @param string $controller
     */
    public function __construct($httpMethod, $path, $controller)
    {
        $this->setHttpMethod($httpMethod);
        $this->setPath($path);
        $this->setController($controller);
    }

    /** @return string */
    public function __toString()
    {
        return md5($this->httpMethod . $this->path . $this->controller);
    }

    /**
     * @param string|array $httpMethod
     * @return $this
     */
    public function setHttpMethod($httpMethod)
    {
        static $validHttpMethods = ['DELETE', 'GET', 'POST', 'PUT'];
        foreach ((array) $httpMethod as $method) {
            $method = strtoupper($method);
            if (!in_array($method, $validHttpMethods)) {
                throw new \UnexpectedValueException(
                    sprintf('Method must be one of: %s', implode(' ', $validHttpMethods))
                );
            }
            $this->httpMethod[] = $method;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * @api
     *
     * @param string $controller
     *
     * @return $this Provides a fluent interface.
     */
    public function setController($controller)
    {
        $this->controller = trim($controller);
        return $this;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @api
     *
     * @param string $path
     *
     * @return $this Provides a fluent interface.
     */
    public function setPath($path)
    {
        $this->path = trim($path);
        return $this;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
