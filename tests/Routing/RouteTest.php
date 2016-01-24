<?php
namespace VisionTest\Routing;

use Vision\Routing\Route;

class RouteTest extends \PHPUnit_Framework_TestCase
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

     /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Method must be one of: DELETE, GET, POST, PUT
     */
    public function testInvalidHttpMethod()
    {
        $route = new Route('FOO', '/', 'foo');
    }
}
