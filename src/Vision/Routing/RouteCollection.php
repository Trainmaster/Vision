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
     * @api
     *
     * @param Route $route
     *
     * @return $this Provides a fluent interface.
     */
    public function add(Route $route)
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

    /**
     * @api
     *
     * @param RouteCollection $collection
     *
     * @return $this Provides a fluent interface.
     */
    public function addRouteCollection(RouteCollection $collection)
    {
        foreach ($collection as $route) {
            $this->add($route);
        }

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
                return $path;
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
}
