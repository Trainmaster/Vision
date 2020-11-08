<?php

declare(strict_types=1);

namespace VisionTest\Routing;

use Vision\File\Loader\IncludeFileLoader;
use Vision\Routing\DefinitionLoader;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Vision\Routing\RouteCollector;

class DefinitionLoaderTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testLoadWithSingleResource()
    {
        $resourceFile = 'path/to/resource';
        $definitionCallback = function (RouteCollector $routeCollector) {
            $routeCollector->addRoute('GET', 'foo', 'someHandler');
        };

        $resources = [$resourceFile];

        /** @var IncludeFileLoader|MockObject $includeFileLoaderMock */
        $includeFileLoaderMock = $this->createMock(IncludeFileLoader::class);
        $includeFileLoaderMock
            ->expects($this->once())
            ->method('load')
            ->with($resourceFile)
            ->willReturn($definitionCallback);

        /** @var RouteCollector|MockObject $routeCollectorMock */
        $routeCollectorMock = $this->createMock(RouteCollector::class);
        $routeCollectorMock
            ->expects($this->once())
            ->method('addRoute');

        $definitionCallback = (new DefinitionLoader($includeFileLoaderMock))
            ->load($resources);
        $definitionCallback($routeCollectorMock);
    }

    /**
     * @throws \ReflectionException
     */
    public function testLoadWithMultipleResources()
    {
        $resourceFileA = 'path/to/resource/a';
        $routeA = ['GET', 'foo', 'someHandler'];
        $resourceDefinitionCallbackA = function (RouteCollector $routeCollector) use ($routeA) {
            $routeCollector->addRoute(...$routeA);
        };

        $resourceFileB = 'path/to/resource/b';
        $routeB = ['POST', 'bar', 'someHandler'];
        $resourceDefinitionCallbackB = function (RouteCollector $routeCollector) use ($routeB) {
            $routeCollector->addRoute('POST', 'bar', 'someHandler');
        };

        $resources = [$resourceFileA, $resourceFileB];

        /** @var IncludeFileLoader|MockObject $includeFileLoaderMock */
        $includeFileLoaderMock = $this->createMock(IncludeFileLoader::class);
        $includeFileLoaderMock
            ->expects($this->exactly(2))
            ->method('load')
            ->withConsecutive([$resourceFileA], [$resourceFileB])
            ->willReturnOnConsecutiveCalls($resourceDefinitionCallbackA, $resourceDefinitionCallbackB);

        /** @var RouteCollector|MockObject $routeCollectorMock */
        $routeCollectorMock = $this->createMock(RouteCollector::class);
        $routeCollectorMock
            ->expects($this->exactly(2))
            ->method('addRoute')
            ->withConsecutive($routeA, $routeB);

        $definitionCallback = (new DefinitionLoader($includeFileLoaderMock))
            ->load($resources);
        $definitionCallback($routeCollectorMock);
    }

    /**
     * @throws \ReflectionException
     */
    public function testLoadIfDefinitionCallbackIsNotCallable()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('The resource "path/to/resource" must return an anonymous function.');

        $resourceFile = 'path/to/resource';
        $definitionCallback = 'isNotCallable';
        $resources = [$resourceFile];

        /** @var IncludeFileLoader|MockObject $includeFileLoaderMock */
        $includeFileLoaderMock = $this->createMock(IncludeFileLoader::class);
        $includeFileLoaderMock
            ->expects($this->once())
            ->method('load')
            ->with($resourceFile)
            ->willReturn($definitionCallback);

        $routeCollectorMock = $this->createMock(RouteCollector::class);

        $definitionCallback = (new DefinitionLoader($includeFileLoaderMock))
            ->load($resources);
        $definitionCallback($routeCollectorMock);
    }

    /**
     * @throws \ReflectionException
     */
    public function testLoadIfDefinitionCallbackDoesNotAcceptRouteCollectorArgument()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('The anonymous function returned by "path/to/resource" must accept a value'
            . ' of type "Vision\Routing\RouteCollector" as Argument 1.');

        $resourceFile = 'path/to/resource';
        $definitionCallback = function () {
        };
        $resources = [$resourceFile];

        /** @var IncludeFileLoader|MockObject $includeFileLoaderMock */
        $includeFileLoaderMock = $this->createMock(IncludeFileLoader::class);
        $includeFileLoaderMock
            ->expects($this->once())
            ->method('load')
            ->with($resourceFile)
            ->willReturn($definitionCallback);

        /** @var RouteCollector|MockObject $routeCollectorMock */
        $routeCollectorMock = $this->createMock(RouteCollector::class);

        $definitionCallback = (new DefinitionLoader($includeFileLoaderMock))
            ->load($resources);
        $definitionCallback($routeCollectorMock);
    }
}
