<?php
namespace Vision\Routing;

use ArrayIterator, IteratorAggregate;
use RuntimeException;

class RouteCollection extends Config\AbstractConfig implements IteratorAggregate
{    
    public function getIterator()
    {
        return new ArrayIterator($this->routes);
    }
    
    public function add($alias, Route $route)
    {
        return parent::addRoute($alias, $route);
    }
    
    public function get($alias)
    {
        return parent::getRoute($alias);
    }
    
    public function has($alias)
    {
        return parent::hasRoute($alias);
    }
    
    public function getAll()
    {
        return parent::getAllRoutes();
    }
    
    public function applyDefaults(array $defaults)
    {
        foreach ($this->routes as &$route) {
            $route->setDefaults($route->getDefaults() + $defaults);
        }
        return $this;
    }
    
    public function applyPrefix($prefix)
    {
        foreach ($this->routes as &$route) {
            $route->setPath($prefix . $route->getPath());
        }
        return $this;
    }   

    public function applyRequirements(array $requirements)
    {
        foreach ($this->routes as &$route) {
            $route->setRequirements($route->getRequirements() + $requirements);
        }
        return $this;
    }
}