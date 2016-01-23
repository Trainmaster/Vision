<?php
namespace VisionTest\Routing;

use Vision\Routing\CompiledRoute;
use Vision\Routing\Route;
use Vision\Routing\RouteCompiler;

class RouteCompilerTest extends \PHPUnit_Framework_TestCase
{
    public function testCompileAndExpectStaticRoute()
    {
        $compiler = new RouteCompiler();

        $expected = [
            'handler' => 'test',
            'httpMethod' => 'GET',
            'path' => '/',
            'type' => CompiledRoute::TYPE_STATIC,
        ];

        $this->assertEquals($expected, $compiler->compile(new Route('GET', '/', 'test')));
    }

    public function testCompileWithRequiredParameter() {
        $compiler = new RouteCompiler();

        $expected = [
            'handler' => 'test',
            'httpMethod' => 'GET',
            'path' => '#^/(?<id>[\w.~-]+)$#Du',
            'type' => CompiledRoute::TYPE_REGEX,
        ];

        $this->assertEquals($expected, $compiler->compile(new Route('GET', '/{id}', 'test')));
    }

    public function testCompileWithOptionalParameter() {
        $compiler = new RouteCompiler();

        $expected = [
            'handler' => 'test',
            'httpMethod' => 'GET',
            'path' => '#^/?(?<id>[\w.~-]+)?$#Du',
            'type' => CompiledRoute::TYPE_REGEX,
        ];

        $this->assertEquals($expected, $compiler->compile(new Route('GET', '/<id>', 'test')));
    }
}
