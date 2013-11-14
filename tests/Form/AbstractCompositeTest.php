<?php
class AbstractCompositeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetElementsIsEmptyArray()
    {
        $compositeType = $this->getMockForAbstractClass('\Vision\Form\AbstractCompositeType', array('foo'));

        $this->assertSame(array(), $compositeType->getElements());
    }

    public function testAddElementAndGetElements()
    {
        $compositeType = $this->getMockForAbstractClass('\Vision\Form\AbstractCompositeType', array('foo'));
        $element = $this->getMockForAbstractClass('\Vision\Form\AbstractType', array('foo'));

        $this->assertSame($compositeType, $compositeType->addElement($element));
        $this->assertContainsOnlyInstancesOf('\Vision\Form\AbstractType', $compositeType->getElements());
        $this->assertCount(1, $compositeType->getElements());
    }

    public function testAddElementsAndGetElements()
    {
        $compositeType = $this->getMockForAbstractClass('\Vision\Form\AbstractCompositeType', array('foo'));
        $element1 = $this->getMockForAbstractClass('\Vision\Form\AbstractType', array('foo'));
        $element2 = clone($element1);

        $this->assertSame($compositeType, $compositeType->addElements(array($element1, $element2)));
        $this->assertContainsOnlyInstancesOf('\Vision\Form\AbstractType', $compositeType->getElements());
        $this->assertCount(2, $compositeType->getElements());
    }
}
