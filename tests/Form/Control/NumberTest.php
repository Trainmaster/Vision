<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Number;

class NumberTest extends \PHPUnit\Framework\TestCase
{
    /** @var Number */
    private $control;

    public function setUp()
    {
        $this->control = new Number('number');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('number', $control->getAttribute('type'));
    }

    public function testSetMin()
    {
        $control = $this->control;

        $this->assertSame($control, $control->setMin(1));
        $this->assertSame(1, $control->getAttribute('min'));
    }

    public function testSetMax()
    {
        $control = $this->control;

        $this->assertSame($control, $control->setMax(1));
        $this->assertSame(1, $control->getAttribute('max'));
    }
}
