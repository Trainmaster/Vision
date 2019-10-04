<?php

namespace VisionTest\Form;

use PHPUnit\Framework\TestCase;

class AbstractCompositeTest extends TestCase
{
    public function testGetElementsIsEmptyArray()
    {
        $compositeType = $this->getMockForAbstractClass('\Vision\Form\AbstractCompositeType', ['foo']);

        $this->assertSame([], $compositeType->getElements());
    }

    public function testAddElementAndGetElements()
    {
        $compositeType = $this->getMockForAbstractClass('\Vision\Form\AbstractCompositeType', ['foo']);
        $element = $this->getMockForAbstractClass('\Vision\Form\AbstractType', ['foo']);

        $this->assertSame($compositeType, $compositeType->addElement($element));
        $this->assertContainsOnlyInstancesOf('\Vision\Form\AbstractType', $compositeType->getElements());
        $this->assertCount(1, $compositeType->getElements());
    }

    public function testAddElementsAndGetElements()
    {
        $compositeType = $this->getMockForAbstractClass('\Vision\Form\AbstractCompositeType', ['foo']);
        $element1 = $this->getMockForAbstractClass('\Vision\Form\AbstractType', ['foo']);
        $element2 = clone($element1);

        $this->assertSame($compositeType, $compositeType->addElements([$element1, $element2]));
        $this->assertContainsOnlyInstancesOf('\Vision\Form\AbstractType', $compositeType->getElements());
        $this->assertCount(2, $compositeType->getElements());
    }

    public function testRemoveElementByName()
    {
        $compositeType = $this->getMockForAbstractClass('\Vision\Form\AbstractCompositeType', ['foo']);
        $element = $this->getMockForAbstractClass('\Vision\Form\AbstractType', ['foo']);

        $compositeType->addElement($element);
        $compositeType->removeElementByName('foo');

        $this->assertCount(0, $compositeType->getElements());
    }
}
