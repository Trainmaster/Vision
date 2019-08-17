<?php
namespace VisionTest\Http;

use Vision\Http\Message;
use Vision\Http\Response;

use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /** @var Response */
    protected $response;

    protected function setUp()
    {
        $this->response = new Response();
    }

    public function testDefaultsAfterConstruct()
    {
        $this->assertSame(200, $this->response->getStatusCode());
        $this->assertSame(Message::PROTOCOL_VERSION_11, $this->response->getProtocolVersion());
    }
    public function testSetStatusCodeShouldProvideFluentInterface()
    {
        $this->assertSame($this->response, $this->response->setStatusCode(500));
    }

    public function testSetStatusCodeShouldAcceptOfficialStatusCode()
    {
        $officialStatusCode = 404;
        $this->response->setStatusCode($officialStatusCode);

        $this->assertSame($officialStatusCode, $this->response->getStatusCode());
    }

    public function testSetStatusCodeShouldNotAcceptCustomStatusCode()
    {
        $customStatusCode = 600;
        $this->response->setStatusCode($customStatusCode);

        $this->assertNotSame($customStatusCode, $this->response->getStatusCode());
    }

    public function testAddHeaderShouldProvideFluentInterface()
    {
        $this->assertSame($this->response, $this->response->addHeader('name', 'value'));
    }

    public function testAddCookieShouldProvideFluentInterface()
    {
        $this->assertSame($this->response, $this->response->addCookie('name', 'value'));
    }

    public function testAddRawCookieShouldProvideFluentInterface()
    {
        $this->assertSame($this->response, $this->response->addRawCookie('name', 'value'));
    }
}
