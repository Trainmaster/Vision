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
        /** @var Validator\ValidatorInterface $validator */
        $validator = $this->createMock(Validator\ValidatorInterface::class);

        $this->chain->add($validator);

        $this->assertInstanceOf(Validator\ValidatorChain::class, $this->chain);
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
        $validator = $this->createMock(Validator\ValidatorInterface::class);
        $validator->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        return $validator;
    }

    protected function createFalseValidator()
    {
        $validator = $this->createMock(Validator\ValidatorInterface::class);
        $validator->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));
        return $validator;
    }
}
