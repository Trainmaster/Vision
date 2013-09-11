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
 * RouteCollection
 *
 * @author Frank Liepert
 */
class RouteCollection implements \IteratorAggregate
{
    /** @type array $routes */
    protected $routes = array();
    
    /**
     * @api
     * 
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->routes);
    }
    
    /**
     * @api
     * 
     * @param array $defaults 
     * 
     * @return RouteCollection Provides a fluent interface.
     */
    public function applyDefaults(array $defaults)
    {
        foreach ($this->routes as &$route) {
            $route->setDefaults($route->getDefaults() + $defaults);
        }
        return $this;
    }

    /**
     * @api
     * 
     * @param string $prefix 
     * 
     * @return RouteCollection Provides a fluent interface.
     */    
    public function applyPrefix($prefix)
    {
        foreach ($this->routes as &$route) {
            $route->setPath($prefix . $route->getPath());
        }
        return $this;
    }   

    /**
     * @api
     * 
     * @param array $requirements 
     * 
     * @return RouteCollection Provides a fluent interface.
     */
    public function applyRequirements(array $requirements)
    {
        foreach ($this->routes as &$route) {
            $route->setRequirements($route->getRequirements() + $requirements);
        }
        return $this;
    }
   
    
    /**
     * @api
     * 
     * @param string $alias 
     * @param Route $route 
     * 
     * @return RouteCollection Provides a fluent interface.
     */
    public function add($alias, Route $route)
    {
        if (isset($this->routes[$alias])) {
            throw new \RuntimeException(sprintf(
                'Route alias "%s" has already been defined.', 
                $alias
            ));
        }
        
        $this->routes[$alias] = $route;
        
        return $this;
    }
    
    /**
     * @api
     * 
     * @param RouteCollection $collection 
     * 
     * @return RouteCollection Provides a fluent interface.
     */
    public function addRouteCollection(RouteCollection $collection)
    {
        foreach ($collection as $alias => $route) {
            $this->add($alias, $route);
        }
        
        return $this;
    }
    
    /**
     * @api
     * 
     * @param string $alias 
     * 
     * @return Route|null
     */
    public function get($alias)
    {
        if (isset($this->routes[$alias])) {
            return $this->routes[$alias];
        }
        
        return null;
    }
    
    /**
     * @api
     * 
     * @param string $alias 
     * 
     * @return bool
     */
    public function has($alias)
    {
        return (bool) isset($this->routes[$alias]);
    }
    
    /**
     * @api
     * 
     * @return array
     */
    public function getAll()
    {
        return $this->routes;
    }
}