<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Color;

class ColorTest extends \PHPUnit_Framework_TestCase
{
    /** @var Color */
    private $control;

    public function setUp()
    {
        $this->control = new Color('color');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('color', $control->getAttribute('type'));
    }
}
