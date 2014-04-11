<?php
namespace VisionTest\Validator;

use Vision\Validator;

class NotNullTest extends \PHPUnit_Framework_TestCase
{
    static $validator;

    public static function setUpBeforeClass()
    {
        self::$validator = new Validator\NotNull;
    }

    public function testSuccess()
    {
        $this->assertTrue(self::$validator->isValid(true));
        $this->assertTrue(self::$validator->isValid(false));
        $this->assertTrue(self::$validator->isValid(0));
        $this->assertTrue(self::$validator->isValid(''));
        $this->assertTrue(self::$validator->isValid('foo'));
        $this->assertTrue(self::$validator->isValid(array()));
    }

    public function testFailure()
    {
        $this->assertFalse(self::$validator->isValid(null));
    }
}
