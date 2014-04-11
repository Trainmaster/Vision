<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Date;

class DateTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->control = new Date('date');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('date', $control->getAttribute('type'));
    }
}
