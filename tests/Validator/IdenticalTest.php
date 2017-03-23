<?php
namespace VisionTest\Validator;

use Vision\Validator;

use PHPUnit\Framework\TestCase;

class IdenticalTest extends TestCase
{
    public function testConstructEmpty()
    {
        $validator = new Validator\Identical;
        $this->assertNull($validator->getOperand());
    }

    public function testConstructWithOperand()
    {
        $validator = new Validator\Identical('foo');
        $this->assertSame('foo', $validator->getOperand());
    }

    public function testSetAndGetOperand()
    {
        $validator = new Validator\Identical;
        $this->assertNull($validator->getOperand());

        $validator->setOperand('foo');
        $this->assertSame('foo', $validator->getOperand());
    }

    public function testSuccess()
    {
        $validator = new Validator\Identical;
        $this->assertTrue($validator->isValid(null));

        $validator->setOperand('');
        $this->assertTrue($validator->isValid(''));

        $validator->setOperand('foo');
        $this->assertTrue($validator->isValid('foo'));

        $validator->setOperand(1);
        $this->assertTrue($validator->isValid(1));

        $object = new \stdClass;
        $validator->setOperand($object);
        $this->assertTrue($validator->isValid($object));
    }

    public function testFailure()
    {
        $validator = new Validator\Identical;
        $this->assertFalse($validator->isValid(''));

        $validator->setOperand(1);
        $this->assertFalse($validator->isValid('1'));

        $validator->setOperand(new \stdClass);
        $this->assertFalse($validator->isValid(new \stdClass));
    }
}
