<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Radio;

class RadioTest extends \PHPUnit_Framework_TestCase
{
    protected $defaultOptions = [
        1 => 'foo',
        2 => 'bar',
        3 => 'baz'
    ];

    public function setUp()
    {
        $this->control = new Radio('radio');
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
        $this->assertSame('radio', $control->getAttribute('type'));
    }

    public function testGetButton()
    {
        $control = $this->control;

        $this->assertNull($this->control->getButton('1'));

        $control->setOptions($this->defaultOptions);

        $control1 = $control->getButton('1');
        $control2 = $control->getButton('2');
        $control3 = $control->getButton('3');

        $this->assertInstanceOf('Vision\Html\Element', $control1);
        $this->assertInstanceOf('Vision\Html\Element', $control2);
        $this->assertInstanceOf('Vision\Html\Element', $control3);

        $this->assertSame($control1, $control->getButton('1'));
    }

    public function testCheckednessWithValueAndOptions()
    {
        $control = $this->control;

        $control->setValue(1);
        $control->setOptions($this->defaultOptions);

        $this->assertNotNull($control->getButton(1)->getAttribute('checked'));
        $this->assertNull($control->getButton(2)->getAttribute('checked'));
        $this->assertNull($control->getButton(3)->getAttribute('checked'));
    }

    public function testCheckednessWithValuesAndOptions()
    {
        $control = $this->control;

        $control->setValue([1, 3]);
        $control->setOptions($this->defaultOptions);

        $this->assertNotNull($control->getButton(1)->getAttribute('checked'));
        $this->assertNull($control->getButton(2)->getAttribute('checked'));
        $this->assertNull($control->getButton(3)->getAttribute('checked'));
    }
}
