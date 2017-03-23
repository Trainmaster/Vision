<?php
namespace VisionTest\Form;

use PHPUnit\Framework\TestCase;

class AbstractTypeTest extends TestCase
{
    public function testGetName()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', ['foo']);

        $this->assertSame('foo', $abstractType->getName());
    }

    public function testGetValidatorsIsEmptyArray()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', ['foo']);

        $this->assertSame([], $abstractType->getValidators());
    }

    public function testAddValidatorAndGetValidators()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', ['foo']);
        $validator = $this->createMock('\Vision\Validator\ValidatorInterface');

        $this->assertSame($abstractType, $abstractType->addValidator($validator));
        $this->assertContainsOnlyInstancesOf('\Vision\Validator\ValidatorInterface', $abstractType->getValidators());
        $this->assertCount(1, $abstractType->getValidators());
    }

    public function testAddValidatorsAndGetValidators()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', ['foo']);
        $validator1 = $this->createMock('\Vision\Validator\ValidatorInterface');
        $validator2 = clone($validator1);

        $this->assertSame($abstractType, $abstractType->addValidators([$validator1, $validator2]));
        $this->assertContainsOnlyInstancesOf('\Vision\Validator\ValidatorInterface', $abstractType->getValidators());
        $this->assertCount(2, $abstractType->getValidators());
    }

    public function testResetValidators()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', ['foo']);
        $validator = $this->createMock('\Vision\Validator\ValidatorInterface');

        $this->assertCount(0, $abstractType->getValidators());

        $abstractType->addValidator($validator);

        $this->assertCount(1, $abstractType->getValidators());

        $abstractType->resetValidators();

        $this->assertCount(0, $abstractType->getValidators());
    }

    public function testSetParent()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', ['foo']);
        $node = $this->createMock('\Vision\DataStructures\Tree\NodeInterface');

        $this->assertSame($abstractType, $abstractType->setParent($node));
    }

    public function testHasChildren()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', ['foo']);

        $this->assertFalse($abstractType->hasChildren());
    }

    public function getChildren()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', ['foo']);

        $this->assertSame([], $abstractType->getChildren());
    }
}
