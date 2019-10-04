<?php

namespace VisionTest\Validator;

use Vision\Validator;
use PHPUnit\Framework\TestCase;

class MaxStringLengthTest extends TestCase
{
    /** @var Validator\MaxStringLength */
    protected $validator;

    protected $singleBytes = ['$', '$$'];

    protected $multiBytes = ['¢', '€', "\xF0\xA4\xAD\xA2", '¢¢', '€€', "\xF0\xA4\xAD\xA2\xF0\xA4\xAD\xA2"];

    protected function setUp()
    {
        $this->validator = new Validator\MaxStringLength(1);
    }

    public function testGetMax()
    {
        $this->assertSame(1, $this->validator->getMax());
    }

    public function testCastToInteger()
    {
        $validator = new Validator\MaxStringLength('1');

        $this->assertSame(1, $validator->getMax());
    }

    public function testSingleByteSuccess()
    {
        $this->assertTrue($this->validator->validate($this->singleBytes[0]));
    }

    public function testSingleByteFailure()
    {
        $this->assertFalse($this->validator->validate($this->singleBytes[1]));
    }

    public function testMultiByteSuccess()
    {
        $this->assertTrue($this->validator->validate($this->multiBytes[0]));
        $this->assertTrue($this->validator->validate($this->multiBytes[1]));
        $this->assertTrue($this->validator->validate($this->multiBytes[2]));
    }

    public function testMultiByteFailure()
    {
        $this->assertFalse($this->validator->validate($this->multiBytes[3]));
        $this->assertFalse($this->validator->validate($this->multiBytes[4]));
        $this->assertFalse($this->validator->validate($this->multiBytes[5]));
    }

    public function testGetErrors()
    {
        $this->validator->validate($this->singleBytes[0]);
        $this->assertEmpty($this->validator->getErrors());

        $this->validator->validate($this->singleBytes[1]);
        $this->assertNotEmpty($this->validator->getErrors());

        $this->validator->validate($this->singleBytes[0]);
        $this->assertEmpty($this->validator->getErrors());
    }
}
