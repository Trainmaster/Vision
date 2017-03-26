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
        $this->assertTrue($this->validator->isValid(true));
        $this->assertTrue($this->validator->isValid(false));
        $this->assertTrue($this->validator->isValid(0));
        $this->assertTrue($this->validator->isValid(''));
        $this->assertTrue($this->validator->isValid('foo'));
        $this->assertTrue($this->validator->isValid([]));
    }

    public function testFailure()
    {
        $this->assertFalse($this->validator->isValid(null));
    }
}
