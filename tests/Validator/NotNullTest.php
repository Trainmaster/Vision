<?php
namespace VisionTest\Validator;

use Vision\Validator;

use PHPUnit\Framework\TestCase;

class NotNullTest extends TestCase
{
    /** @var Validator\NotNull */
    protected $validator;

    protected function setUp()
    {
        $this->validator = new Validator\NotNull;
    }

    public function testSuccess()
    {
        $this->assertTrue($this->validator->validate(true));
        $this->assertTrue($this->validator->validate(false));
        $this->assertTrue($this->validator->validate(0));
        $this->assertTrue($this->validator->validate(''));
        $this->assertTrue($this->validator->validate('foo'));
        $this->assertTrue($this->validator->validate([]));
    }

    public function testFailure()
    {
        $this->assertFalse($this->validator->validate(null));
    }
}
