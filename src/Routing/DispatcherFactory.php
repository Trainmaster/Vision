<?php

declare(strict_types=1);

namespace Vision\Routing;

use FastRoute\Dispatcher;

use function FastRoute\simpleDispatcher;

class DispatcherFactory
{
    /**
     * @param callable $routeDefinitionCallback
     * @param array $options
     * @return Dispatcher
     */
    public function make(callable $routeDefinitionCallback, array $options = []): Dispatcher
    {
        return simpleDispatcher($routeDefinitionCallback, self::overwriteRouteCollector($options));
    }

    /**
     * @param array $options
     * @return array
     */
    private static function overwriteRouteCollector(array $options): array
    {
        $options['routeCollector'] = RouteCollector::class;
        return $options;
    }
}
