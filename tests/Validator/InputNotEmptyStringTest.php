<?php

namespace VisionTest\Validator;

use Vision\Validator;
use PHPUnit\Framework\TestCase;

class InputNotEmptyStringTest extends TestCase
{
    /** @var Validator\InputNotEmptyString */
    protected $validator;

    protected function setUp()
    {
        $this->validator = new Validator\InputNotEmptyString();
    }

    public function testSuccess()
    {
        $this->assertTrue($this->validator->validate(' '));
        $this->assertTrue($this->validator->validate('0'));
        $this->assertTrue($this->validator->validate(['0', 0]));
        $this->assertTrue($this->validator->validate([['0', 0]]));
        $this->assertTrue($this->validator->validate(new \stdClass()));
        $this->assertTrue($this->validator->validate(false));
        $this->assertTrue($this->validator->validate(null));
        $this->assertTrue($this->validator->validate(0));
        $this->assertTrue($this->validator->validate(0.1));
        $this->assertTrue($this->validator->validate([]));
        $this->assertTrue($this->validator->validate([[]]));
    }

    public function testFailure()
    {
        $this->assertFalse($this->validator->validate(''));
        $this->assertFalse($this->validator->validate(['']));
        $this->assertFalse($this->validator->validate(['foo', '']));
        $this->assertFalse($this->validator->validate([['']]));
    }
}
