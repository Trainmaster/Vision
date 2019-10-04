<?php

namespace VisionTest\Validator;

use Vision\Validator\InputInteger;
use PHPUnit\Framework\TestCase;

class InputIntegerTest extends TestCase
{
    /** @var InputInteger */
    protected $validator;

    /** @var InputInteger */
    protected $minValidator;

    /** @var InputInteger */
    protected $maxValidator;

    /** @var InputInteger */
    protected $minAndMaxValidator;

    protected function setUp()
    {
        $this->validator = new InputInteger();
        $this->minValidator = new InputInteger(1);
        $this->maxValidator = new InputInteger(null, 1);
        $this->minAndMaxValidator = new InputInteger(1, 2);
    }

    public function testSuccess()
    {
        $this->assertTrue($this->validator->validate('-1'));
        $this->assertTrue($this->validator->validate('0'));
        $this->assertTrue($this->validator->validate('1'));

        if (version_compare(PHP_VERSION, '5.4.11') >= 0) {
            $this->assertTrue($this->validator->validate('-0'));
            $this->assertTrue($this->validator->validate('+0'));
        }
    }

    public function testFailure()
    {
        $this->assertFalse($this->validator->validate(''));
        $this->assertFalse($this->validator->validate('1.0'));

        if (version_compare(PHP_VERSION, '5.4.11') < 0) {
            $this->assertFalse($this->validator->validate('-0'));
            $this->assertFalse($this->validator->validate('+0'));
        }
    }

    public function testMinSuccess()
    {
        $this->assertTrue($this->minValidator->validate('1'));
        $this->assertTrue($this->minValidator->validate('2'));
    }

    public function testMinFailure()
    {
        $this->assertFalse($this->minValidator->validate('-1'));
        $this->assertFalse($this->minValidator->validate('0'));
    }

    public function testMaxSuccess()
    {
        $this->assertTrue($this->maxValidator->validate('-1'));
        $this->assertTrue($this->maxValidator->validate('0'));
        $this->assertTrue($this->maxValidator->validate('1'));
    }

    public function testMaxFailure()
    {
        $this->assertFalse($this->maxValidator->validate('2'));
    }

    public function testMinAndMaxSuccess()
    {
        $this->assertTrue($this->minAndMaxValidator->validate('1'));
        $this->assertTrue($this->minAndMaxValidator->validate('2'));
    }

    public function testMinAndMaxFailure()
    {
        $this->assertFalse($this->minAndMaxValidator->validate('-1'));
        $this->assertFalse($this->minAndMaxValidator->validate('0'));
        $this->assertFalse($this->minAndMaxValidator->validate('3'));
    }
}
