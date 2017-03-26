<?php
namespace VisionTest\Validator;

use Vision\Validator\Email;

use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    /** @var Email */
    protected $validator;

    protected function setUp()
    {
        $this->validator = new Email;
    }

    public function testSuccess()
    {
        $this->assertTrue($this->validator->isValid('foo@bar.com'));
    }

    public function testFailure()
    {
        $this->assertFalse($this->validator->isValid(''));
    }
}
