<?php
use Vision\Validator;

class InputNotEmptyStringTest extends \PHPUnit_Framework_TestCase
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
        $this->assertTrue(self::$validator->isValid(array('0', 0)));
        $this->assertTrue(self::$validator->isValid(array(array('0', 0))));
    }

    public function testFailure()
    {
        $this->assertFalse(self::$validator->isValid(new stdClass));
        $this->assertFalse(self::$validator->isValid(false));
        $this->assertFalse(self::$validator->isValid(null));
        $this->assertFalse(self::$validator->isValid(0));
        $this->assertFalse(self::$validator->isValid(0.1));
        $this->assertFalse(self::$validator->isValid(''));
        $this->assertFalse(self::$validator->isValid(array('')));
        $this->assertFalse(self::$validator->isValid(array(array(''))));
        $this->assertFalse(self::$validator->isValid(array()));
        $this->assertFalse(self::$validator->isValid(array(array())));
    }
}
