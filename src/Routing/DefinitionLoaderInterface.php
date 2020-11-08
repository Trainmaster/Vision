<?php

declare(strict_types=1);

namespace Vision\Routing;

use Closure;

interface DefinitionLoaderInterface
{
    /**
     * @param array $resources
     * @return Closure The anonymous function must accept a value of type {@link RouteCollector} as Argument 1
     */
    public function load(array $resources): Closure;
}
