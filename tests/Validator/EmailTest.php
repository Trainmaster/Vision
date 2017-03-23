<?php
namespace VisionTest\Validator;

use Vision\Validator\Email;

use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    static $validator;

    public static function setUpBeforeClass()
    {
        self::$validator = new Email;
    }

    public function testSuccess()
    {
        $this->assertTrue(self::$validator->isValid('foo@bar.com'));
    }

    public function testFailure()
    {
        $this->assertFalse(self::$validator->isValid(''));
    }
}
