<?php
namespace VisionTest\Validator;

use Vision\Validator\InputInteger;

use PHPUnit\Framework\TestCase;

class InputIntegerTest extends TestCase
{
    static $validator;

    static $minValidator;

    static $maxValidator;

    static $minAndMaxValidator;

    public static function setUpBeforeClass()
    {
        self::$validator = new InputInteger;
        self::$minValidator = new InputInteger(1);
        self::$maxValidator = new InputInteger(null, 1);
        self::$minAndMaxValidator = new InputInteger(1, 2);
    }

    public function testSuccess()
    {
        $this->assertTrue(self::$validator->isValid('-1'));
        $this->assertTrue(self::$validator->isValid('0'));
        $this->assertTrue(self::$validator->isValid('1'));

        if (version_compare(PHP_VERSION, '5.4.11') >= 0) {
            $this->assertTrue(self::$validator->isValid('-0'));
            $this->assertTrue(self::$validator->isValid('+0'));
        }
    }

    public function testFailure()
    {
        $this->assertFalse(self::$validator->isValid(''));
        $this->assertFalse(self::$validator->isValid('1.0'));

        if (version_compare(PHP_VERSION, '5.4.11') < 0) {
            $this->assertFalse(self::$validator->isValid('-0'));
            $this->assertFalse(self::$validator->isValid('+0'));
        }
    }

    public function testMinSuccess()
    {
        $this->assertTrue(self::$minValidator->isValid('1'));
        $this->assertTrue(self::$minValidator->isValid('2'));
    }

    public function testMinFailure()
    {
        $this->assertFalse(self::$minValidator->isValid('-1'));
        $this->assertFalse(self::$minValidator->isValid('0'));
    }

    public function testMaxSuccess()
    {
        $this->assertTrue(self::$maxValidator->isValid('-1'));
        $this->assertTrue(self::$maxValidator->isValid('0'));
        $this->assertTrue(self::$maxValidator->isValid('1'));
    }

    public function testMaxFailure()
    {
        $this->assertFalse(self::$maxValidator->isValid('2'));
    }

    public function testMinAndMaxSuccess()
    {
        $this->assertTrue(self::$minAndMaxValidator->isValid('1'));
        $this->assertTrue(self::$minAndMaxValidator->isValid('2'));
    }

    public function testMinAndMaxFailure()
    {
        $this->assertFalse(self::$minAndMaxValidator->isValid('-1'));
        $this->assertFalse(self::$minAndMaxValidator->isValid('0'));
        $this->assertFalse(self::$minAndMaxValidator->isValid('3'));
    }
}
