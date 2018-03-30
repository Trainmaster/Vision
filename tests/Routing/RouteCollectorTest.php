<?php

declare(strict_types=1);

namespace VisionTest\Routing;

use Vision\Routing\RouteCollector;
use FastRoute\DataGenerator;
use FastRoute\RouteParser;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RouteCollectorTest extends TestCase
{
    /** @var RouteCollector */
    protected $routeCollector;

    /** @var RouteParser|MockObject */
    private $routeParserMock;

    /** @var DataGenerator|MockObject */
    private $dataGeneratorMock;

    /**
     * @throws \ReflectionException
     */
    protected function setUp(): void
    {
        $this->routeParserMock = $this->createMock(RouteParser::class);
        $this->dataGeneratorMock = $this->createMock(DataGenerator::class);

        $this->routeCollector = new RouteCollector($this->routeParserMock, $this->dataGeneratorMock);
    }

    public function testAddRouteWithSimpleRoute()
    {
        $handler = 'someHandler';
        $expectedHandler = [$handler];

        $this->routeParserMock
            ->expects($this->once())
            ->method('parse')
            ->willReturn(['someRoutePart']);

        $this->dataGeneratorMock
            ->expects($this->once())
            ->method('addRoute')
            ->with('GET', $this->anything(), $expectedHandler);

        $this->routeCollector->addRoute('GET', '/test', $handler);
    }

    public function testAddRouteWithRouteGroup()
    {
        $groupHandler = 'groupHandler';
        $routeHandler = 'routeHandler';
        $expectedHandler = [$groupHandler, $routeHandler];

        $this->routeParserMock
            ->expects($this->once())
            ->method('parse')
            ->willReturn(['someRoutePart']);

        $this->dataGeneratorMock
            ->expects($this->once())
            ->method('addRoute')
            ->with('GET', $this->anything(), $expectedHandler);

        $this->routeCollector->addGroup('/some-prefix', function (RouteCollector $routeCollector) use ($routeHandler) {
            $routeCollector->get('/foo', $routeHandler);
        }, [$groupHandler]);
    }

    public function testAddRouteWithMultipleRouteGroups()
    {
        $outerGroupHandler = 'outerGroupHandler';
        $innerGroupHandler = 'innerGroupHandler';
        $routeHandler = 'someHandler';
        $expectedHandler = [$outerGroupHandler, $innerGroupHandler, $routeHandler];

        $this->routeParserMock
            ->expects($this->once())
            ->method('parse')
            ->willReturn(['someRoutePart']);

        $this->dataGeneratorMock
            ->expects($this->once())
            ->method('addRoute')
            ->with('GET', $this->anything(), $expectedHandler);

        $this->routeCollector->addGroup(
            '/some-prefix',
            function (RouteCollector $routeCollector) use ($innerGroupHandler, $routeHandler) {
                $routeCollector->addGroup(
                    '/another-prefix',
                    function (RouteCollector $routeCollector) use ($routeHandler) {
                        $routeCollector->get('/foo', $routeHandler);
                    },
                    [$innerGroupHandler]
                );
            },
            [$outerGroupHandler]
        );
    }
}
