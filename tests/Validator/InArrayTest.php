<?php
namespace VisionTest\Validator;

use Vision\Validator;

class InArrayTest extends \PHPUnit_Framework_TestCase
{
    static $validator = null;

    static $strictValidator = null;

    protected static $haystack = array(
        'foo',
        'bar',
        true
    );

    public static function setUpBeforeClass()
    {
        self::$strictValidator = new Validator\InArray(self::$haystack);
        self::$validator = new Validator\InArray(self::$haystack, false);
    }

    public function testSuccess()
    {
        $this->assertTrue(self::$validator->isValid(1));
        $this->assertTrue(self::$validator->isValid('1'));
        $this->assertTrue(self::$validator->isValid(true));
        $this->assertTrue(self::$validator->isValid('foo'));
        $this->assertTrue(self::$validator->isValid(array('foo', 'bar')));
        $this->assertTrue(self::$validator->isValid('baz'));
        $this->assertTrue(self::$validator->isValid(array('baz')));
    }

    public function testFailure()
    {
        $this->assertFalse(self::$strictValidator->isValid(1));
        $this->assertFalse(self::$strictValidator->isValid('1'));
        $this->assertFalse(self::$strictValidator->isValid('baz'));
        $this->assertFalse(self::$strictValidator->isValid(array('baz')));
    }
}
