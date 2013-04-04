<?php
namespace Vision\Routing\Config;

use Vision\Routing\Route;
use Vision\Routing\RouteCollection;

use RuntimeException;

abstract class AbstractConfig
{
    protected $routes = array();
    
    public function addRoute($alias, Route $route)
    {
        if (isset($this->routes[$alias])) {
            throw new RuntimeException(sprintf('Route alias "%s" is already defined', $alias));
        }
        $this->routes[$alias] = $route;
        return $this;
    }
    public function addRouteCollection(RouteCollection $collection)
    {
        foreach ($collection as $alias => &$route) {
            $this->addRoute($alias, $route);
        }
        return $this;
    }
    
    public function getRoute($alias)
    {
        if (isset($this->routes[$alias])) {
            return $this->routes[$alias];
        }
        return null;
    }
    
    public function hasRoute($alias)
    {
        return (bool) isset($this->routes[$alias]);
    }
    
    public function getRoutes()
    {
        return $this->routes;
    }
}