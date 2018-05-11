<?php

declare(strict_types=1);

namespace Vision\Routing;

use FastRoute\Dispatcher;

class Router
{
    /** @var DispatcherFactory */
    private $dispatcherFactory;

    /** @var DefinitionLoaderInterface */
    private $definitionLoader;

    /** @var string[] $resources */
    private $resources = [];

    /**
     * @param DispatcherFactory $dispatcherFactory
     * @param DefinitionLoaderInterface $definitionLoader
     */
    public function __construct(DispatcherFactory $dispatcherFactory, DefinitionLoaderInterface $definitionLoader)
    {
        $this->dispatcherFactory = $dispatcherFactory;
        $this->definitionLoader = $definitionLoader;
    }

    /**
     * @param string $resource
     * @return Router
     */
    public function addResource(string $resource): self
    {
        $this->resources[] = $resource;
        return $this;
    }

    /**
     * @param string $httpMethod
     * @param string $uri
     * @return array|null
     */
    public function resolve(string $httpMethod, string $uri): ?array
    {
        return $this->makeResult(
            $this->dispatcherFactory
                ->make($this->definitionLoader->load($this->resources))
                ->dispatch($httpMethod, $uri)
        );
    }

    /**
     * @param array $dispatchResult
     * @return array|null
     */
    private function makeResult(array $dispatchResult): ?array
    {
        $status = $dispatchResult[0] ?? Dispatcher::NOT_FOUND;
        switch ($status) {
            case Dispatcher::FOUND:
                return [
                    'handler' => $dispatchResult[1] ?? [],
                    'parameters' => $dispatchResult[2] ?? [],
                ];

            case Dispatcher::METHOD_NOT_ALLOWED:
                return [
                    'allowedMethods' => $dispatchResult[1] ?? [],
                ];

            case Dispatcher::NOT_FOUND:
            default:
                return null;
        }
    }
}
