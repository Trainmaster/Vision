<?php

declare(strict_types=1);

namespace VisionTest\Routing;

use Vision\Cache\CacheInterface;
use Vision\Routing\CachedDefinitionLoader;
use Vision\Routing\DefinitionLoader;
use Vision\Routing\RouteCollector;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CachedDefinitionLoaderTest extends TestCase
{
    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function testLoadShouldUseCacheEntry()
    {
        $resources = ['path/to/resource'];
        $expectedDefinitionCallback = function (RouteCollector $routeCollector) {
        };

        /** @var DefinitionLoader|MockObject $definitionLoaderMock */
        $definitionLoaderMock = $this->createMock(DefinitionLoader::class);
        $definitionLoaderMock
            ->expects($this->never())
            ->method('load');

        $cachePrefix = CachedDefinitionLoader::class;
        /** @var CacheInterface|MockObject $cacheMock */
        $cacheMock = $this->createMock(CacheInterface::class);
        $cacheMock
            ->expects($this->once())
            ->method('get')
            ->with("{$cachePrefix}_12eedaa93e6385b2b54fdf4f60030846")
            ->willReturn($expectedDefinitionCallback);

        $definitionCallback = (new CachedDefinitionLoader($definitionLoaderMock, $cacheMock))
            ->load($resources);

        $this->assertSame($expectedDefinitionCallback, $definitionCallback);
    }

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function testLoadShouldFallBackToDefinitionLoader()
    {
        $resourceFile = 'path/to/resource';
        $resources = [$resourceFile];
        $expectedDefinitionCallback = function (RouteCollector $routeCollector) {
        };

        /** @var DefinitionLoader|MockObject $definitionLoaderMock */
        $definitionLoaderMock = $this->createMock(DefinitionLoader::class);
        $definitionLoaderMock
            ->expects($this->once())
            ->method('load')
            ->with($resources)
            ->willReturn($expectedDefinitionCallback);

        $cachePrefix = CachedDefinitionLoader::class;
        $expectedCacheKey = "{$cachePrefix}_12eedaa93e6385b2b54fdf4f60030846";
        /** @var CacheInterface|MockObject $cacheMock */
        $cacheMock = $this->createMock(CacheInterface::class);
        $cacheMock
            ->expects($this->once())
            ->method('get')
            ->with($expectedCacheKey)
            ->willReturn(false);
        $cacheMock
            ->expects($this->once())
            ->method('set')
            ->with($expectedCacheKey, $expectedDefinitionCallback);

        $definitionCallback = (new CachedDefinitionLoader($definitionLoaderMock, $cacheMock))
            ->load($resources);

        $this->assertSame($expectedDefinitionCallback, $definitionCallback);
    }
}
