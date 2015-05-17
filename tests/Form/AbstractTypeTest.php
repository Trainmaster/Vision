<?php
namespace VisionTest\Form;

class AbstractTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', array('foo'));

        $this->assertSame('foo', $abstractType->getName());
    }

    public function testGetValidatorsIsEmptyArray()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', array('foo'));

        $this->assertSame(array(), $abstractType->getValidators());
    }

    public function testAddValidatorAndGetValidators()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', array('foo'));
        $validator = $this->getMock('\Vision\Validator\ValidatorInterface');

        $this->assertSame($abstractType, $abstractType->addValidator($validator));
        $this->assertContainsOnlyInstancesOf('\Vision\Validator\ValidatorInterface', $abstractType->getValidators());
        $this->assertCount(1, $abstractType->getValidators());
    }

    public function testAddValidatorsAndGetValidators()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', array('foo'));
        $validator1 = $this->getMock('\Vision\Validator\ValidatorInterface');
        $validator2 = clone($validator1);

        $this->assertSame($abstractType, $abstractType->addValidators(array($validator1, $validator2)));
        $this->assertContainsOnlyInstancesOf('\Vision\Validator\ValidatorInterface', $abstractType->getValidators());
        $this->assertCount(2, $abstractType->getValidators());
    }

    public function testResetValidators()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', array('foo'));
        $validator = $this->getMock('\Vision\Validator\ValidatorInterface');

        $this->assertCount(0, $abstractType->getValidators());

        $abstractType->addValidator($validator);

        $this->assertCount(1, $abstractType->getValidators());

        $abstractType->resetValidators();

        $this->assertCount(0, $abstractType->getValidators());
    }

    public function testSetParent()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', array('foo'));
        $node = $this->getMock('\Vision\DataStructures\Tree\NodeInterface');

        $this->assertSame($abstractType, $abstractType->setParent($node));
    }

    public function testHasChildren()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', array('foo'));

        $this->assertFalse($abstractType->hasChildren());
    }

    public function getChildren()
    {
        $abstractType = $this->getMockForAbstractClass('\Vision\Form\AbstractType', array('foo'));

        $this->assertSame(array(), $abstractType->getChildren());
    }
}
