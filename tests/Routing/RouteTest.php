<?php
namespace VisionTest\Routing;

use Vision\Routing\Route;

class RouteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Method must be one of: DELETE, GET, POST, PUT
     */
    public function testInvalidHttpMethod()
    {
        $route = new Route('FOO', '/', 'foo');
    }
}
