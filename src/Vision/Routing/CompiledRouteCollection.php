<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Routing;

class CompiledRouteCollection implements \IteratorAggregate
{
    /** @var array $routes */
    protected $routes = [];

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->routes);
    }

    /**
     * @param string $alias
     * @param AbstractCompiledRoute $route
     *
     * @return $this Provides a fluent interface.
     */
    public function add($alias, AbstractCompiledRoute $route)
    {
        $this->routes[$alias] = $route;

        return $this;
    }

    /**
     * @param string $alias
     *
     * @return AbstractCompiledRoute|null
     */
    public function getRoute($alias)
    {
        if (isset($this->routes[$alias])) {
            return $this->routes[$alias];
        }

        return null;
    }

    /**
     * @param string $alias
     *
     * @return bool
     */
    public function hasRoute($alias)
    {
        return (bool) isset($this->routes[$alias]);
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}
