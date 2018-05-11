<?php

declare(strict_types=1);

namespace VisionTest\Routing;

use Vision\File\Loader\IncludeFileLoader;
use Vision\Routing\DefinitionLoader;
use Vision\Routing\DispatcherFactory;
use Vision\Routing\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /** @var Router */
    protected $router;

    /** @var string */
    private const ROUTES_RESOURCE = __DIR__ . DIRECTORY_SEPARATOR . 'routes.php';

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->router = (
            new Router(
                new DispatcherFactory(),
                new DefinitionLoader(new IncludeFileLoader())
            ))
            ->addResource(self::ROUTES_RESOURCE);
    }

    public function testResolveShouldReturnMatchedRoute()
    {
        $httpMethod = 'GET';
        $uri = '/foo';

        $expectedRoute = [
            'handler' => ['someHandler'],
            'parameters' => [],
        ];

        $this->assertSame($expectedRoute, $this->router->resolve($httpMethod, $uri));
    }

    public function testResolveShouldReturnAllowedMethods()
    {
        $httpMethod = 'POST';
        $uri = '/foo';

        $expectedRoute = [
            'allowedMethods' => ['GET'],
        ];

        $this->assertSame($expectedRoute, $this->router->resolve($httpMethod, $uri));
    }

    public function testResolveShouldReturnNullIfRouteIsNotFound()
    {
        $httpMethod = 'GET';
        $uri = '/bar';

        $this->assertNull($this->router->resolve($httpMethod, $uri));
    }
}
