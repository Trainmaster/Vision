<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
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
     * @param string $prefix
     *
     * @return $this Provides a fluent interface.
     */
    public function applyPrefix($prefix)
    {
        foreach ($this->routes as &$route) {
            $route = new Route(
                $route->getHttpMethod(),
                $prefix . $route->getPath(),
                $route->getHandler()
            );
        }
        return $this;
    }

    /**
     * @param string|string[] $httpMethod
     * @param string $path
     * @param string $handler
     * @return $this
     */
    public function add($httpMethod, $path, $handler)
    {
        foreach ((array) $httpMethod as $method) {
            $this->addRoute(new Route($method, $path, $handler));
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
        foreach ($this->routes as $route) {
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
