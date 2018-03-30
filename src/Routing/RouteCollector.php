<?php

declare(strict_types=1);

namespace Vision\Routing;

class RouteCollector extends \FastRoute\RouteCollector
{
    /** @var array */
    private $currentGroupHandlers = [];

    /**
     * @param string $prefix
     * @param callable $callback
     * @param array $handlers
     * @return void
     */
    public function addGroup($prefix, callable $callback, array $handlers = []): void
    {
        $previousGroupHandlers = $this->currentGroupHandlers;
        $this->currentGroupHandlers = array_merge($previousGroupHandlers, $handlers);

        parent::addGroup($prefix, $callback);

        $this->currentGroupHandlers = $previousGroupHandlers;
    }

    /**
     * @param string|string[] $httpMethod
     * @param string $route
     * @param mixed $handler
     * @return void
     */
    public function addRoute($httpMethod, $route, $handler): void
    {
        if (!is_array($handler)) {
            $handler = [$handler];
        }

        $handler = array_merge($this->currentGroupHandlers, $handler);
        parent::addRoute($httpMethod, $route, $handler);
    }
}
