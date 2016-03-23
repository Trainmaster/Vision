<?php
namespace VisionTest\Form\Control;

class AbstractControlTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->control = $this->getMockForAbstractClass('\Vision\Form\Control\AbstractControl', ['abstract']);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertNull($control->getLabel());
        $this->assertNull($control->getPlaceholder());
        $this->assertFalse($control->isRequired());
        $this->assertNull($control->getData());
        $this->assertNull($control->getValue());
        $this->assertSame([], $control->getFilters());
        $this->assertSame([], $control->getErrors());
        $this->assertFalse($control->hasChildren());
        $this->assertSame([], $control->getChildren());
    }

    /**
     * @expectedException LogicException
     * @expectedExceptionMessage The element may only be validated once per life-cycle.
     */
    public function testIsValidLoopException()
    {
        $control = $this->control;

        $control->isValid();
        $control->isValid();
    }

    public function testNullData()
    {
        $control = $this->control;

        $this->assertTrue($control->isValid());
        $this->assertSame(null, $control->getValue());
        $this->assertEmpty($control->getErrors());
    }

    public function testNullDataWhenIsRequired()
    {
        $control = $this->control;
        $control->setRequired(true);

        $this->assertFalse($control->isValid());
        $this->assertSame(null, $control->getValue());
        $this->assertNotEmpty($control->getErrors());
    }

    public function testEmptyStringData()
    {
        $control = $this->control;
        $control->setData('');

        $this->assertTrue($control->isValid());
        $this->assertSame('', $control->getValue());
        $this->assertEmpty($control->getErrors());
    }

    public function testEmptyStringDataWhenIsRequired()
    {
        $control = $this->control;
        $control->setRequired(true);
        $control->setData('');

        $this->assertFalse($control->isValid());
        $this->assertSame(null, $control->getValue());
        $this->assertNotEmpty($control->getErrors());
    }

    public function testZeroAsStringData()
    {
        $control = $this->control;
        $control->setData('0');

        $this->assertTrue($control->isValid());
        $this->assertSame('0', $control->getValue());
        $this->assertEmpty($control->getErrors());
    }

    public function testZeroAsStringDataWhenIsRequired()
    {
        $control = $this->control;
        $control->setRequired(true);
        $control->setData('0');

        $this->assertTrue($control->isValid());
        $this->assertSame('0', $control->getValue());
        $this->assertEmpty($control->getErrors());
    }
}
