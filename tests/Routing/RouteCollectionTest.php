<?php
namespace VisionTest\Routing;

use Vision\Routing\Route;
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

    public function testApplyPrefix()
    {
        $collection = new RouteCollection();
        $collection->add('GET', '/login', 'foo');
        $collection->add('GET', '/logout', 'bar');
        $collection->applyPrefix('/administration');

        $this->assertInstanceOf(Route::class, $collection->get('/administration/login'));
        $this->assertInstanceOf(Route::class, $collection->get('/administration/logout'));
        $this->assertNull($collection->get('/login'));
        $this->assertNull($collection->get('/logout'));
    }

    public function testMerge()
    {
        $collectionA = new RouteCollection();
        $collectionA->add('GET', '/foo', 'foo');

        $collectionB = new RouteCollection();
        $collectionB->add('GET', '/bar', 'bar');

        $this->assertNull($collectionA->get('/bar'));
        $collectionA->merge($collectionB);
        $this->assertInstanceOf(Route::class, $collectionA->get('/bar'));
    }

    public function testIterable()
    {
        $collection = new RouteCollection();
        $collection->add('GET', '/', 'foo');
        $this->assertInstanceOf(\IteratorAggregate::class, $collection);
        foreach ($collection as $route) {
            $this->assertInstanceOf(Route::class, $route);
        }
    }
}
