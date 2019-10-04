<?php

declare(strict_types=1);

namespace VisionTest\Url;

use Vision\Url\UrlFromServerFactory;
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
            'HTTP_HOST' => 'localhost:8090',
            'SERVER_PORT' => '8080',
            'REQUEST_URI' => '/path/to/index.php?key=value',
            'QUERY_STRING' => 'key=value'
        ];

        $url = UrlFromServerFactory::make($server);

        $this->assertSame($expectedUrl, $url->__toString());
    }

    public function testShouldIgnoreEmptyQueryString()
    {
        $expectedUrl = 'http://localhost:8080/path/to/index.php';
        $server = [
            'HTTP_HOST' => 'localhost:8080',
            'SERVER_PORT' => '8080',
            'REQUEST_URI' => '/path/to/index.php',
            'QUERY_STRING' => ''
        ];

        $url = UrlFromServerFactory::make($server);

        $this->assertSame($expectedUrl, $url->__toString());
    }

    public function testShouldPreferHttpHost()
    {
        $expectedUrl = 'https://subdomain.example.com/path/to/index.php';
        $server = [
            'HTTP_HOST' => 'subdomain.example.com',
            'HTTPS' => 'on',
            'SERVER_NAME' => 'example.com',
            'SERVER_PORT' => '443',
            'REQUEST_URI' => '/path/to/index.php',
        ];

        $url = UrlFromServerFactory::make($server);

        $this->assertSame($expectedUrl, $url->__toString());
    }
}
