<?php

namespace VisionTest\Validator;

use Vision\Validator;
use PHPUnit\Framework\TestCase;
use stdClass;

class IdenticalTest extends TestCase
{
    /** @var Validator\Identical */
    protected $validator;
    
    protected function setUp()
    {
        $this->validator = new Validator\Identical();
    }

    public function testConstructEmpty()
    {
        $this->assertNull($this->validator->getOperand());
    }

    public function testConstructWithOperand()
    {
        $this->assertSame('foo', (new Validator\Identical('foo'))->getOperand());
    }

    public function testSetAndGetOperand()
    {
        $this->assertNull($this->validator->getOperand());

        $this->validator->setOperand('foo');
        $this->assertSame('foo', $this->validator->getOperand());
    }

    public function testSuccess()
    {
        $this->assertTrue($this->validator->validate(null));

        $this->validator->setOperand('');
        $this->assertTrue($this->validator->validate(''));

        $this->validator->setOperand('foo');
        $this->assertTrue($this->validator->validate('foo'));

        $this->validator->setOperand(1);
        $this->assertTrue($this->validator->validate(1));

        $object = new stdClass();
        $this->validator->setOperand($object);
        $this->assertTrue($this->validator->validate($object));
    }

    public function testFailure()
    {
        $this->assertFalse($this->validator->validate(''));

        $this->validator->setOperand(1);
        $this->assertFalse($this->validator->validate('1'));

        $this->validator->setOperand(new stdClass());
        $this->assertFalse($this->validator->validate(new stdClass()));
    }
}
