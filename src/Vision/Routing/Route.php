<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Routing;

/**
 * Route
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Route extends AbstractRoute
{
    /** @type null|string $controller */
    protected $controller = null;

    /** @type null|string $path */
    protected $path = null;

    /**
     * @param string $path
     * @param string $controller
     */
    public function __construct($path, $controller)
    {
        $this->setPath($path);
        $this->setController($controller);
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
