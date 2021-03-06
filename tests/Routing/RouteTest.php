<?php

namespace VisionTest\Routing;

use Vision\Routing\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function testConstructor()
    {
        $route = new Route('GET', '/', 'foo');
        $this->assertSame('GET', $route->getHttpMethod());
        $this->assertSame('/', $route->getPath());
        $this->assertSame('foo', $route->getHandler());
    }

    public function testToString()
    {
        $route = new Route('GET', '/', 'foo');
        $this->assertSame('f1384e92bb8faa64d7cacf0d599f833d', (string) $route);
    }

    public function testInvalidHttpMethod()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Method must be one of: DELETE, HEAD, GET, OPTIONS, POST, PUT');
        new Route('FOO', '/', 'foo');
    }
}
