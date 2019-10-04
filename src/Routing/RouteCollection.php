<?php
declare(strict_types=1);

namespace Vision\Routing;

class RouteCollection implements \IteratorAggregate
{
    /** @var Route[] $routes */
    protected $routes = [];

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->routes);
    }

    /**
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
     * @param RouteCollection $collection
     * @return $this
     */
    public function merge(RouteCollection $collection)
    {
        $routes = $collection->getAll();
        array_walk($routes, [$this, 'addRoute']);
        return $this;
    }

    /**
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
