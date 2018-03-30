<?php
declare(strict_types = 1);

namespace VisionTest\Http;

use Vision\Http\UrlFromServerFactory;

use PHPUnit\Framework\TestCase;

class UrlFromServerFactoryTest extends TestCase
{
    public function testShouldReturnTheExpectedUrl()
    {
        $expectedUrl = 'http://localhost:8080/path/to/index.php?key=value';
        $server = [
            'SERVER_NAME' => 'localhost',
            'SERVER_PORT' => '8080',
            'REQUEST_URI' => '/path/to/index.php?key=value',
            'QUERY_STRING' => 'key=value'
        ];

        $url = UrlFromServerFactory::make($server);

        $this->assertSame($expectedUrl, $url->__toString());
    }

    public function testShouldUseHttpHostIfServerNameIsNotAvailable()
    {
        $expectedUrl = 'http://localhost:8080/path/to/index.php?key=value';
        $server = [
            'HTTP_HOST' => 'localhost',
            'SERVER_PORT' => '8080',
            'REQUEST_URI' => '/path/to/index.php?key=value',
            'QUERY_STRING' => 'key=value'
        ];

        $url = UrlFromServerFactory::make($server);

        $this->assertSame($expectedUrl, $url->__toString());
    }

    public function testShouldIgnoreOptionalPortInHttpHost()
    {
        $expectedUrl = 'http://localhost:8080/path/to/index.php?key=value';
        $server = [
            'HTTP_HOST' => 'localhost:8080',
            'SERVER_PORT' => '8080',
            'REQUEST_URI' => '/path/to/index.php?key=value',
            'QUERY_STRING' => 'key=value'
        ];

        $url = UrlFromServerFactory::make($server);

        $this->assertSame($expectedUrl, $url->__toString());
    }
}
