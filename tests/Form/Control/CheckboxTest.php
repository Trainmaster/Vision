<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\Checkbox;
use PHPUnit\Framework\TestCase;

class CheckboxTest extends TestCase
{
    /** @var Checkbox */
    private $control;

    protected $defaultOptions = [
        1 => 'foo',
        2 => 'bar',
        3 => 'baz'
    ];

    public function setUp()
    {
        $this->control = new Checkbox('checkbox');
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
        $this->assertSame('checkbox', $control->getAttribute('type'));
    }

    public function testGetCheckbox()
    {
        $control = $this->control;

        $this->assertNull($this->control->getCheckbox('1'));

        $control->setOptions($this->defaultOptions);

        $control1 = $control->getCheckbox('1');
        $control2 = $control->getCheckbox('2');
        $control3 = $control->getCheckbox('3');

        $this->assertInstanceOf('Vision\Html\Element', $control1);
        $this->assertInstanceOf('Vision\Html\Element', $control2);
        $this->assertInstanceOf('Vision\Html\Element', $control3);

        $this->assertSame($control1, $control->getCheckbox('1'));
    }

    public function testCheckednessWithValueAndOptions()
    {
        $control = $this->control;

        $control->setValue(1);
        $control->setOptions($this->defaultOptions);

        $this->assertNotNull($control->getCheckbox(1)->getAttribute('checked'));
        $this->assertNull($control->getCheckbox(2)->getAttribute('checked'));
        $this->assertNull($control->getCheckbox(3)->getAttribute('checked'));
    }

    public function testCheckednessWithValuesAndOptions()
    {
        $control = $this->control;

        $control->setValue([1, 3]);
        $control->setOptions($this->defaultOptions);

        $this->assertNotNull($control->getCheckbox(1)->getAttribute('checked'));
        $this->assertNull($control->getCheckbox(2)->getAttribute('checked'));
        $this->assertNotNull($control->getCheckbox(3)->getAttribute('checked'));
    }
}
