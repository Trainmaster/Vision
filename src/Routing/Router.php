<?php
declare(strict_types = 1);

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

    /** @var array $routes */
    protected $routes = [];

    /**
     * @param RouteCompiler $compiler
     */
    public function __construct(RouteCompiler $compiler)
    {
        $this->compiler = $compiler;
    }

    /**
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
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
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
     * @return array
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @param RequestInterface $request
     * @return array|null
     */
    public function resolve(RequestInterface $request)
    {
        $pathInfo = $request->getPathInfo();

        if (!$this->processCache()) {
            $this->loadResources();
        }

        if (!isset($this->routes[$request->getMethod()])) {
            return null;
        }

        foreach ($this->routes[$request->getMethod()] as $route) {
            if ($route['type'] === CompiledRoute::TYPE_STATIC && $route['path'] === $pathInfo) {
                return $route;
            }

            if ($route['type'] === CompiledRoute::TYPE_REGEX && preg_match($route['path'], $pathInfo, $matches)) {
                $route['params'] = $matches;
                return $route;
            }
        }

        return null;
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

            foreach ($collection as $route) {
                $compiledRoute = $this->compiler->compile($route);
                $this->routes[array_shift($compiledRoute)][] = $compiledRoute;
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

        if ($routes) {
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
