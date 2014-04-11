<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Button;

class ButtonTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->control = new Button('button');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('button', $control->getAttribute('type'));
    }
}
