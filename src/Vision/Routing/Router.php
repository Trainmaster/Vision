<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Routing;

use Vision\Cache\CacheInterface;
use Vision\Http\RequestInterface;

class Router
{
    /** @var CacheInterface $cache */
    protected $cache;

    /** @var RouteCompiler $compiler */
    protected $compiler;

    /** @var array $resources */
    protected $resources = [];

    /** @var CompiledRouteCollection $routes */
    protected $routes;

    /**
     * @param RequestInterface $request
     */
    public function __construct()
    {
        $this->routes = new CompiledRouteCollection;
    }

    /**
     * @api
     *
     * @param CacheInterface $cache
     *
     * @return Router Provides a fluent interface.
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * @api
     *
     * @param string $alias
     * @param AbstractCompiledRoute $route
     *
     * @return Router Provides a fluent interface.
     */
    public function addRoute($alias, AbstractCompiledRoute $route)
    {
        $this->routes->add($alias, $route);
        return $this;
    }

    /**
     * @api
     *
     * @param array $routes
     *
     * @return Router Provides a fluent interface.
     */
    public function addRoutes(array $routes)
    {
        foreach ($routes as $alias => $route) {
            $this->addRoute($alias, $route);
        }

        return $this;
    }

    /**
     * @api
     *
     * @return CompiledRouteCollection
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @api
     *
     * @param string $resource
     *
     * @return Router Provides a fluent interface.
     */
    public function addResource($resource)
    {
        $this->resources[] = (string) $resource;
        return $this;
    }

    /**
     * @api
     *
     * @return array
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @param RequestInterface $request
     * @return Route|null
     */
    public function resolve(RequestInterface $request)
    {
        $match = false;
        $method = $request->getMethod();
        $pathInfo = $request->getPathInfo();

        if (!$this->processCache()) {
            $this->loadResources();
        }

        foreach ($this->routes as $route) {

            $allowedMethod = $route->getHttpMethod();

            if (isset($allowedMethod)) {
                if (strcasecmp($method, $allowedMethod) !== 0) {
                    continue;
                }
            }

            if ($route instanceof StaticRoute) {
                $path = $route->getPath();
                if ($pathInfo === $path) {
                    $match = true;
                }
            } elseif ($route instanceof RegexRoute) {
                $regex = $route->getRegex();
                if (preg_match($regex, $pathInfo, $matches)) {
                    $match = true;
                }
            }

            if (!$match) {
                continue;
            }

            break;
        }

        if (!empty($matches)) {
            foreach ($matches as $key => $value) {
                if (is_string($key)) {
                    $request->GET[$key] = $value;
                }
            }
        }

        if ($match) {
            $defaults = $route->getDefaults();
            if (!empty($defaults)) {
                foreach ($defaults as $key => $value) {
                    $request->GET[$key] = $value;
                }
            }
            return $route;
        }

        return null;
    }

    /**
     * Initializes the route compiler if needed.
     *
     * @return Router Provides a fluent interface.
     */
    protected function initRouteCompiler()
    {
        $this->compiler = new RouteCompiler;
        return $this;
    }

    /**
     * @throws \InvalidArgumentException If a configuration file does not return a RouteCollection.
     *
     * @return bool
     */
    protected function loadResources()
    {
        if (empty($this->resources)) {
            return false;
        }

        $this->initRouteCompiler();

        foreach ($this->resources as $resource) {
            if (!is_readable($resource)) {
                throw new \InvalidArgumentException(sprintf(
                    'The file "%s" could not be loaded.',
                    $resource
                ));
            }

            $collection = include $resource;

            if (!($collection instanceof RouteCollection)){
                throw new \InvalidArgumentException(sprintf(
                    'The file %s must return an instance of %s.',
                    $resource,
                    RouteCollection::class
                ));
            }

            foreach ($collection as $key => $route) {
                $compiledRoute = $this->compiler->compile($route);
                $this->addRoute($key, $compiledRoute);
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function processCache()
    {
        if (!isset($this->cache)) {
            return false;
        }

        $id = $this->getCacheKey();
        $routes = $this->cache->get($id);

        if ($routes instanceof CompiledRouteCollection) {
            $this->routes = $routes;
        } else {
            $this->loadResources();
            $this->cache->set($id, $this->routes);
        }

        return true;
    }

    /**
     * @return string
     */
    protected function getCacheKey()
    {
        return __CLASS__ . serialize($this->resources);
    }
}
