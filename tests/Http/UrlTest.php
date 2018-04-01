<?php
declare(strict_types = 1);

namespace VisionTest\Http;

use Vision\Http\Url;

use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function testShouldNotRenderPort80IfSchemeIsHttp()
    {
        $expectedUrl = 'http://localhost';

        $url = (new Url())
            ->setScheme('http')
            ->setHost('localhost')
            ->setPort(80);

        $this->assertSame($expectedUrl, $url->__toString());
    }

    public function testShouldNotRenderPort443IfSchemeIsHttps()
    {
        $expectedUrl = 'https://localhost';

        $url = (new Url())
            ->setScheme('https')
            ->setHost('localhost')
            ->setPort(443);

        $this->assertSame($expectedUrl, $url->__toString());
    }

    public function testShouldRenderNonDefaultPort()
    {
        $expectedUrl = 'https://localhost:8080';

        $url = (new Url())
            ->setScheme('https')
            ->setHost('localhost')
            ->setPort(8080);

        $this->assertSame($expectedUrl, $url->__toString());
    }
}
