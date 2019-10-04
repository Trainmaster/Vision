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
        $this->validator = new Validator\Integer();
    }

    public function testSuccess()
    {
        $this->assertTrue($this->validator->validate(-1));
        $this->assertTrue($this->validator->validate(-0));
        $this->assertTrue($this->validator->validate(0));
        $this->assertTrue($this->validator->validate(+0));
        $this->assertTrue($this->validator->validate(1));
    }

    public function testFailure()
    {
        $this->assertFalse($this->validator->validate(new \stdClass()));
        $this->assertFalse($this->validator->validate(false));
        $this->assertFalse($this->validator->validate(null));
        $this->assertFalse($this->validator->validate(0.1));
        $this->assertFalse($this->validator->validate(''));
        $this->assertFalse($this->validator->validate([]));
    }
}
