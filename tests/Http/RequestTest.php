<?php
namespace VisionTest\Http;

use Vision\Http\Request;
use Vision\Http\Url;

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testItShouldSetRequestMethod()
    {
        $requestMethod = 'POST';
        $serverParams = ['REQUEST_METHOD' => $requestMethod];
        $request = new Request(new Url(), [], [], $serverParams, [], []);

        $this->assertSame($requestMethod, $request->getMethod());
    }

    public function testItShouldSetHostUsingHttpHost()
    {
        $httpHost = 'localhost';
        $serverParams = ['HTTP_HOST' => $httpHost];
        $request = new Request(new Url(), [], [], $serverParams, [], []);

        $this->assertSame($httpHost, $request->getHost());
    }

    public function testItShouldNotSetHostIfHttpHostContainsInvalidCharacters()
    {
        $httpHostWithInvalidCharacters = 'localhost*';
        $serverParams = ['HTTP_HOST' => $httpHostWithInvalidCharacters];
        $request = new Request(new Url(), [], [], $serverParams, [], []);

        $this->assertNull($request->getHost());
    }

    public function testItShouldNotSetHostIfItExceedsMaxLength()
    {
        $maxLength = 255;
        $httpHostExceeding255Characters = str_repeat('localhost', 30);
        $serverParams = ['HTTP_HOST' => $httpHostExceeding255Characters];
        $request = new Request(new Url(), [], [], $serverParams, [], []);

        $this->assertGreaterThan($maxLength, strlen($httpHostExceeding255Characters));
        $this->assertNull($request->getHost());
    }

    public function testItShouldSetBasePath()
    {
        $serverParams = ['SCRIPT_NAME' => '/foo/index.php'];
        $request = new Request(new Url(), [], [], $serverParams, [], []);

        $this->assertSame('/foo', $request->getBasePath());

        $serverParams = ['SCRIPT_NAME' => '/index.php'];
        $request = new Request(new Url(), [], [], $serverParams, [], []);

        $this->assertSame('', $request->getBasePath());
    }

    public function testItShouldSetPathInfoUsingPathInfo()
    {
        $serverParams = ['PATH_INFO' => '/foo'];
        $request = new Request(new Url(), [], [], $serverParams, [], []);

        $this->assertSame('/foo', $request->getPathInfo());
    }

    public function testItShouldSetPathInfoUsingRequestUri()
    {
        $serverParams = ['REQUEST_URI' => '/foo'];
        $request = new Request(new Url(), [], [], $serverParams, [], []);

        $this->assertSame('/foo', $request->getPathInfo());
    }
}

