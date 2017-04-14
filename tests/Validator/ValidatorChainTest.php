<?php
namespace VisionTest\Validator;

use Vision\Validator;

use PHPUnit\Framework\TestCase;

class ValidatorChainTest extends TestCase
{
    /** @var Validator\ValidatorChain */
    private $chain;

    public function setUp()
    {
        $this->chain = new Validator\ValidatorChain;
    }

    public function testAddValidator()
    {
        /** @var Validator\Validator $validator */
        $validator = $this->createMock(Validator\Validator::class);

        $this->chain->add($validator);

        $this->assertInstanceOf(Validator\ValidatorChain::class, $this->chain);
    }

    public function testSuccess()
    {
        $validator = $this->createTrueValidator();
        $this->chain->add($validator);

        $this->assertTrue($this->chain->validate(''));
    }

    public function testFailure()
    {
        $validator = $this->createFalseValidator();
        $this->chain->add($validator);

        $this->assertFalse($this->chain->validate(''));
    }

    protected function createTrueValidator()
    {
        $validator = $this->createMock(Validator\Validator::class);
        $validator->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));
        return $validator;
    }

    protected function createFalseValidator()
    {
        $validator = $this->createMock(Validator\Validator::class);
        $validator->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(false));
        return $validator;
    }
}
