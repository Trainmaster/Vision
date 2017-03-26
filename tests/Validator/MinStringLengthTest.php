<?php
namespace VisionTest\Validator;

use Vision\Validator;

use PHPUnit\Framework\TestCase;

class MinStringLengthTest extends TestCase
{
    /** @var Validator\MinStringLength */
    protected $validatorOne;

    /** @var Validator\MinStringLength */
    protected $validatorTwo;

    protected $singleBytes = ['$'];

    protected $multiBytes = ['¢', '€'];

    protected function setUp()
    {
        $this->validatorOne = new Validator\MinStringLength(1);
        $this->validatorTwo = new Validator\MinStringLength(2);
    }

    public function testGetMin()
    {
        $this->assertSame(1, $this->validatorOne->getMin());
    }

    public function testCastToInteger()
    {
        $validator = new Validator\MinStringLength('1');

        $this->assertSame(1, $validator->getMin());
    }

    public function testSingleByteSuccess()
    {
        $this->assertTrue($this->validatorOne->isValid($this->singleBytes[0]));
    }

    public function testSingleByteFailure()
    {
        $this->assertFalse($this->validatorTwo->isValid($this->singleBytes[0]));
    }

    public function testMultiByteSuccess()
    {
        foreach ($this->multiBytes as $byte) {
            $this->assertTrue($this->validatorOne->isValid($byte));
        }
    }

    public function testMultiByteFailure()
    {
        foreach ($this->multiBytes as $byte) {
            $this->assertFalse($this->validatorTwo->isValid($byte));
        }
    }

    public function testGetErrors()
    {
        $this->validatorOne->isValid($this->singleBytes[0]);
        $this->assertEmpty($this->validatorOne->getErrors());

        $this->validatorOne->isValid('');
        $this->assertNotEmpty($this->validatorOne->getErrors());

        $this->validatorOne->isValid($this->singleBytes[0]);
        $this->assertEmpty($this->validatorOne->getErrors());
    }
}
