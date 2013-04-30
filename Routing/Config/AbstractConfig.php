<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Routing\Config;

use Vision\Routing\Route;
use Vision\Routing\RouteCollection;

use RuntimeException;

/**
 * AbstractConfig
 *
 * @author Frank Liepert
 */
abstract class AbstractConfig
{
    /**
     * @type array
     */
    protected $routes = array();
    
    /**
     * 
     * 
     * @param string $alias 
     * @param Route $route 
     * 
     * @return AbstractConfig
     */
    public function addRoute($alias, Route $route)
    {
        if (isset($this->routes[$alias])) {
            throw new RuntimeException(sprintf('Route alias "%s" is already defined', $alias));
        }
        $this->routes[$alias] = $route;
        return $this;
    }
    
    /**
     * 
     * 
     * @param RouteCollection $collection 
     * 
     * @return AbstractConfig
     */
    public function addRouteCollection(RouteCollection $collection)
    {
        foreach ($collection as $alias => &$route) {
            $this->addRoute($alias, $route);
        }
        return $this;
    }
    
    /**
     * 
     * 
     * @param string $alias 
     * 
     * @return Route|null
     */
    public function getRoute($alias)
    {
        if (isset($this->routes[$alias])) {
            return $this->routes[$alias];
        }
        return null;
    }
    
    /**
     * 
     * 
     * @param string $alias 
     * 
     * @return boll
     */
    public function hasRoute($alias)
    {
        return (bool) isset($this->routes[$alias]);
    }
    
    /**
     * 
     * 
     * 
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}