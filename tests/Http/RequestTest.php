<?php

namespace VisionTest\Http;

use Vision\Http\Request;
use Vision\Url\Url;
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

    public function testGetBaseUrlWithSimpleUrl()
    {
        $url = (new Url('http://localhost/foo'));
        $serverParams = ['SCRIPT_NAME' => '/index.php'];
        $request = new Request($url, [], [], $serverParams, [], []);

        $this->assertSame('http://localhost/', $request->getBaseUrl());
    }

    public function testGetBaseUrlWithComplexUrl()
    {
        $url = (new Url('http://localhost:8080/foo/bar?key=value#fragment'));
        $serverParams = ['SCRIPT_NAME' => '/foo/index.php'];
        $request = new Request($url, [], [], $serverParams, [], []);

        $this->assertSame('http://localhost:8080/foo/', $request->getBaseUrl());
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
