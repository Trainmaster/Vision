<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\DateTime;

class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->control = new DateTime('datetime');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('datetime', $control->getAttribute('type'));
    }
}
