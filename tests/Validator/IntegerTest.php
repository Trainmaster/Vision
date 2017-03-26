<?php
namespace VisionTest\Validator;

use Vision\Validator;

use PHPUnit\Framework\TestCase;

class IntegerTest extends TestCase
{
    /** @var Validator\Integer */
    protected $validator;

    protected function setUp()
    {
        $this->validator = new Validator\Integer;
    }

    public function testSuccess()
    {
        $this->assertTrue($this->validator->isValid(-1));
        $this->assertTrue($this->validator->isValid(-0));
        $this->assertTrue($this->validator->isValid(0));
        $this->assertTrue($this->validator->isValid(+0));
        $this->assertTrue($this->validator->isValid(1));
    }

    public function testFailure()
    {
        $this->assertFalse($this->validator->isValid(new \stdClass));
        $this->assertFalse($this->validator->isValid(false));
        $this->assertFalse($this->validator->isValid(null));
        $this->assertFalse($this->validator->isValid(0.1));
        $this->assertFalse($this->validator->isValid(''));
        $this->assertFalse($this->validator->isValid([]));
    }
}
