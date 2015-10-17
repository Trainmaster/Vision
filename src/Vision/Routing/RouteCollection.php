<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Routing;

class RouteCollection implements \IteratorAggregate
{
    /** @var Route[] $routes */
    protected $routes = [];

    /**
     * @api
     *
     * @return \ArrayIterator
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
     * @return $this Provides a fluent interface.
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
     * @return $this Provides a fluent interface.
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
     * @return $this Provides a fluent interface.
     */
    public function applyRequirements(array $requirements)
    {
        foreach ($this->routes as &$route) {
            $route->setRequirements($route->getRequirements() + $requirements);
        }
        return $this;
    }

    /**
     * @param string|string[] $httpMethod
     * @param string $path
     * @param string $controller
     * @return $this
     */
    public function add($httpMethod, $path, $controller)
    {
        foreach ((array) $httpMethod as $method) {
            $this->addRoute(new Route($method, $path, $controller));
        }
        return $this;
    }

    /**
     * @api
     *
     * @param self $collection
     *
     * @return $this Provides a fluent interface.
     */
    public function merge(self $collection)
    {
        $routes = $collection->getAll();
        array_walk($routes, [$this, 'addRoute']);
        return $this;
    }

    /**
     * @api
     *
     * @param string $path
     *
     * @return Route|null
     */
    public function get($path)
    {
        foreach ($this as $route) {
            if ($route->getPath() === $path) {
                return $route;
            }
        }

        return null;
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

    /**
     * @param Route $route
     * @return $this
     */
    private function addRoute(Route $route)
    {
        if (isset($this->routes[(string) $route])) {
            throw new \RuntimeException(sprintf(
                'Route "%s" has already been defined.',
                $route->getPath()
            ));
        }
        $this->routes[(string) $route] = $route;
        return $this;
    }
}
