<?php
namespace VisionTest\Validator;

use Vision\Validator;

class InputNotEmptyStringTest extends \PHPUnit\Framework\TestCase
{
    static $validator;

    public static function setUpBeforeClass()
    {
        self::$validator = new Validator\InputNotEmptyString;
    }

    public function testSuccess()
    {
        $this->assertTrue(self::$validator->isValid(' '));
        $this->assertTrue(self::$validator->isValid('0'));
        $this->assertTrue(self::$validator->isValid(['0', 0]));
        $this->assertTrue(self::$validator->isValid([['0', 0]]));
        $this->assertTrue(self::$validator->isValid(new \stdClass));
        $this->assertTrue(self::$validator->isValid(false));
        $this->assertTrue(self::$validator->isValid(null));
        $this->assertTrue(self::$validator->isValid(0));
        $this->assertTrue(self::$validator->isValid(0.1));
        $this->assertTrue(self::$validator->isValid([]));
        $this->assertTrue(self::$validator->isValid([[]]));
    }

    public function testFailure()
    {
        $this->assertFalse(self::$validator->isValid(''));
        $this->assertFalse(self::$validator->isValid(['']));
        $this->assertFalse(self::$validator->isValid(['foo', '']));
        $this->assertFalse(self::$validator->isValid([['']]));
    }
}
