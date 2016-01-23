<?php
namespace VisionTest\Routing;

use Vision\Routing\RouteCollection;

class RouteCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testAddAndGet()
    {
        $httpMethod = 'GET';
        $path = '/';
        $controller = 'foo';

        $collection = new RouteCollection();
        $collection->add($httpMethod, $path, $controller);

        $this->assertCount(1, $collection->getAll());

        $route = $collection->get('/');

        $this->assertInstanceOf('Vision\Routing\Route', $route);
        $this->assertSame($httpMethod, $route->getHttpMethod());
        $this->assertSame($path, $route->getPath());
        $this->assertSame($controller, $route->getHandler());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Route "/" has already been defined.
     */
    public function testAddDuplicateThrowsException()
    {
        $collection = new RouteCollection();
        $collection->add('GET', '/', 'foo');
        $collection->add('GET', '/', 'foo');
    }
}
