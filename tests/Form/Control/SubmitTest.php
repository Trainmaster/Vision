<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Submit;

class SubmitTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->control = new Submit('submit');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('submit', $control->getAttribute('type'));
    }
}