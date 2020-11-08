<?php

declare(strict_types=1);

namespace Vision\Routing;

use Vision\File\Loader\IncludeFileLoader;
use Closure;

class DefinitionLoader implements DefinitionLoaderInterface
{
    /** @var IncludeFileLoader */
    private $fileLoader;

    /**
     * @param IncludeFileLoader $fileLoader
     */
    public function __construct(IncludeFileLoader $fileLoader)
    {
        $this->fileLoader = $fileLoader;
    }

    /**
     * @param array $resources
     * @return Closure
     */
    public function load(array $resources): Closure
    {
        return function (RouteCollector $routeCollector) use ($resources) {
            foreach ($resources as $resource) {
                $this->loadSingleResource($resource)($routeCollector);
            }
        };
    }

    /**
     * @param string $resource
     * @return callable
     * @throws \Exception
     */
    private function loadSingleResource(string $resource)
    {
        $definitionCallback = $this->fileLoader->load($resource);

        if ((!($definitionCallback instanceof Closure))) {
            throw new \Exception(sprintf('The resource "%s" must return an anonymous function.', $resource));
        }

        $firstParameter = (new \ReflectionFunction($definitionCallback))->getParameters()[0] ?? null;

        if ($firstParameter === null) {
            throw new \Exception(sprintf(
                'The anonymous function returned by "%s" must accept a value of type "%s" as Argument 1.',
                $resource,
                RouteCollector::class
            ));
        }

        return $definitionCallback;
    }
}
