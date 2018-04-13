<?php
declare(strict_types = 1);

namespace VisionTest\Http;

use Vision\Http\Request;
use Vision\Http\RequestFactory;

use PHPUnit\Framework\TestCase;

class RequestFactoryTest extends TestCase
{
    /** @var RequestFactory */
    protected $requestFactory;

    protected function setUp()
    {
        $this->requestFactory = new RequestFactory();
    }

    public function testShouldReturnRequestInstance()
    {
        $request = $this->requestFactory->make();

        $this->assertInstanceOf(Request::class, $request);
    }
}
