<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Select;

class SelectTest extends \PHPUnit_Framework_TestCase
{
    protected $defaultOptions = [
        1 => 'foo',
        2 => 'bar',
        3 => 'baz'
    ];

    public function setUp()
    {
        $this->control = new Select('select');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractOptionControl', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertTrue($control->isRequired());
        $this->assertSame('', (string) $control);
        $this->assertSame('select', $control->getTag());
        $this->assertSame(null, $control->getSize());
        $this->assertSame(null, $control->getMultiple());
    }

    public function testSetAndGetSize()
    {
        $control = $this->control;

        $this->assertSame($control, $control->setSize(1));
        $this->assertSame(1, $control->getSize());
    }

    public function testSetAndGetMultiple()
    {
        $control = $this->control;

        $this->assertSame($control, $control->setMultiple(true));
        $this->assertTrue($control->getMultiple());

        $this->assertSame($control, $control->setMultiple(false));
        $this->assertNull($control->getMultiple());
    }

    public function testCheckednessWithValueAndOptions()
    {
        $control = $this->control;

        $control->setValue(1);
        $control->setOptions($this->defaultOptions);

        $this->assertNotNull($control->getOption(1)->getAttribute('selected'));
        $this->assertNull($control->getOption(2)->getAttribute('selected'));
        $this->assertNull($control->getOption(3)->getAttribute('selected'));
    }

    public function testCheckednessWithValuesAndOptions()
    {
        $control = $this->control;

        $control->setValue([1, 3]);
        $control->setOptions($this->defaultOptions);

        $this->assertNotNull($control->getOption(1)->getAttribute('selected'));
        $this->assertNull($control->getOption(2)->getAttribute('selected'));
        $this->assertNotNull($control->getOption(3)->getAttribute('selected'));
    }
}
