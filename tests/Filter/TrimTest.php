<?php

namespace VisionTest\Filter;

use Vision\Filter\Trim;
use PHPUnit\Framework\TestCase;

class TrimTest extends TestCase
{
    /** @var Trim */
    protected $filter;

    protected function setUp()
    {
        $this->filter = new Trim();
    }

    public function testFilter()
    {
        $this->assertSame('foo', $this->filter->filter(' foo '));
    }
}
