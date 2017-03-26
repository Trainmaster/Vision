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
        $this->validator = new Validator\InputNotEmptyString;
    }

    public function testSuccess()
    {
        $this->assertTrue($this->validator->isValid(' '));
        $this->assertTrue($this->validator->isValid('0'));
        $this->assertTrue($this->validator->isValid(['0', 0]));
        $this->assertTrue($this->validator->isValid([['0', 0]]));
        $this->assertTrue($this->validator->isValid(new \stdClass));
        $this->assertTrue($this->validator->isValid(false));
        $this->assertTrue($this->validator->isValid(null));
        $this->assertTrue($this->validator->isValid(0));
        $this->assertTrue($this->validator->isValid(0.1));
        $this->assertTrue($this->validator->isValid([]));
        $this->assertTrue($this->validator->isValid([[]]));
    }

    public function testFailure()
    {
        $this->assertFalse($this->validator->isValid(''));
        $this->assertFalse($this->validator->isValid(['']));
        $this->assertFalse($this->validator->isValid(['foo', '']));
        $this->assertFalse($this->validator->isValid([['']]));
    }
}
