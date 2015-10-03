<?php
namespace VisionTest\Validator;

use Vision\Validator;

class ValidatorChainTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->chain = new Validator\ValidatorChain;
    }

    public function testAddValidator()
    {
        $validator = $this->getMock('\Vision\Validator\ValidatorInterface');
        $this->chain->add($validator);

        $this->assertAttributeEquals([$validator], 'validators', $this->chain);
        $this->assertInstanceOf('\Vision\Validator\ValidatorChain', $this->chain);
    }

    public function testSuccess()
    {
        $validator = $this->createTrueValidator();
        $this->chain->add($validator);

        $this->assertTrue($this->chain->isValid(''));
    }

    public function testFailure()
    {
        $validator = $this->createFalseValidator();
        $this->chain->add($validator);

        $this->assertFalse($this->chain->isValid(''));
    }

    protected function createTrueValidator()
    {
        $validator = $this->getMock('\Vision\Validator\ValidatorInterface');
        $validator->expects($this->once())
                  ->method('isValid')
                  ->will($this->returnValue(true));
        return $validator;
    }

    protected function createFalseValidator()
    {
        $validator = $this->getMock('\Vision\Validator\ValidatorInterface');
        $validator->expects($this->once())
                  ->method('isValid')
                  ->will($this->returnValue(false));
        return $validator;
    }
}
