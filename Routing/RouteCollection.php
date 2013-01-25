<?php
namespace Vision\Routing;

use ArrayIterator, IteratorAggregate;
use Vision\Routing\Route;

class RouteCollectionException extends \Exception {}

class RouteCollection implements IteratorAggregate
{
    private $routes = array();
    
    private $prefix = null;
    
    private $suffix = null;
    
    public function getIterator()
    {
        return new ArrayIterator($this->routes);
    }
    
    public function add(Route $route)
    {
        if (isset($this->routes[$route->getName()])) {
            throw new RouteCollectionException(sprintf(
                'The route "%s" is already defined.', 
                $route->getName()
            ));
        }
        return $this->routes[$route->getName()] = $route;
    }
    
    public function get($name) {
        if (isset($this->routes[$name])) {
            return $this->routes[$name];
        }
        return null;
    }
    public function getAll() {
        return $this->routes;
    }
    
    public function setPrefix($prefix) {
        $this->prefix = (string) $prefix;
        return $this;
    }
    
    public function getPrefix() {
        return $this->prefix;
    }

    public function setSuffix($suffix) {
        $this->suffix = (string) $suffix;
        return $this;
    }

    public function getSuffix() {
        return $suffix;
    }
}