<?php

namespace VisionTest\Form;

use PHPUnit\Framework\TestCase;
use Vision\DataStructures\Tree\NodeInterface;
use Vision\Form\AbstractType;
use Vision\Validator\Validator;

class AbstractTypeTest extends TestCase
{
    public function testGetName()
    {
        $abstractType = $this->getMockForAbstractClass(AbstractType::class, ['foo']);

        $this->assertSame('foo', $abstractType->getName());
    }

    public function testGetValidatorsIsEmptyArray()
    {
        $abstractType = $this->getMockForAbstractClass(AbstractType::class, ['foo']);

        $this->assertSame([], $abstractType->getValidators());
    }

    public function testAddValidatorAndGetValidators()
    {
        $abstractType = $this->getMockForAbstractClass(AbstractType::class, ['foo']);
        $validator = $this->createMock(Validator::class);

        $this->assertSame($abstractType, $abstractType->addValidator($validator));
        $this->assertContainsOnlyInstancesOf('\Vision\Validator\Validator', $abstractType->getValidators());
        $this->assertCount(1, $abstractType->getValidators());
    }

    public function testAddValidatorsAndGetValidators()
    {
        $abstractType = $this->getMockForAbstractClass(AbstractType::class, ['foo']);
        $validator1 = $this->createMock(Validator::class);
        $validator2 = clone($validator1);

        $this->assertSame($abstractType, $abstractType->addValidators([$validator1, $validator2]));
        $this->assertContainsOnlyInstancesOf(Validator::class, $abstractType->getValidators());
        $this->assertCount(2, $abstractType->getValidators());
    }

    public function testResetValidators()
    {
        $abstractType = $this->getMockForAbstractClass(AbstractType::class, ['foo']);
        $validator = $this->createMock(Validator::class);

        $this->assertCount(0, $abstractType->getValidators());

        $abstractType->addValidator($validator);

        $this->assertCount(1, $abstractType->getValidators());

        $abstractType->resetValidators();

        $this->assertCount(0, $abstractType->getValidators());
    }

    public function testSetParent()
    {
        $abstractType = $this->getMockForAbstractClass(AbstractType::class, ['foo']);
        $node = $this->createMock(NodeInterface::class);

        $this->assertSame($abstractType, $abstractType->setParent($node));
    }

    public function testHasChildren()
    {
        $abstractType = $this->getMockForAbstractClass(AbstractType::class, ['foo']);

        $this->assertFalse($abstractType->hasChildren());
    }

    public function getChildren()
    {
        $abstractType = $this->getMockForAbstractClass(AbstractType::class, ['foo']);

        $this->assertSame([], $abstractType->getChildren());
    }
}
