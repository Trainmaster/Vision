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
            'httpMethod' => 'GET',
            'handler' => 'test',
            'path' => '/',
            'type' => CompiledRoute::TYPE_STATIC,
        ];

        $this->assertSame($expected, $compiler->compile(new Route('GET', '/', 'test')));
    }

    public function testCompileWithRequiredParameter() {
        $compiler = new RouteCompiler();

        $expected = [
            'httpMethod' => 'GET',
            'handler' => 'test',
            'path' => '#^/(?<id>[\w.~-]+)$#Du',
            'type' => CompiledRoute::TYPE_REGEX,
        ];

        $this->assertSame($expected, $compiler->compile(new Route('GET', '/{id}', 'test')));
    }

    public function testCompileWithOptionalParameter() {
        $compiler = new RouteCompiler();

        $expected = [
            'httpMethod' => 'GET',
            'handler' => 'test',
            'path' => '#^/?(?<id>[\w.~-]+)?$#Du',
            'type' => CompiledRoute::TYPE_REGEX,
        ];

        $this->assertSame($expected, $compiler->compile(new Route('GET', '/<id>', 'test')));
    }
}
