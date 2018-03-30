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

