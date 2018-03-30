<?php

declare(strict_types=1);

namespace VisionTest\Routing;

use Vision\Routing\DispatcherFactory;
use FastRoute\Dispatcher;
use PHPUnit\Framework\TestCase;

class DispatcherFactoryTest extends TestCase
{
    public function testMake()
    {
        $routeDefinitionCallback = function () {
        };
        $dispatcher = (new DispatcherFactory())->make($routeDefinitionCallback);

        $this->assertInstanceOf(Dispatcher::class, $dispatcher);
    }
}
