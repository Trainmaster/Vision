<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\DateTimeLocal;

class DateTimeLocalTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->control = new DateTimeLocal('datetime-local');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('datetime-local', $control->getAttribute('type'));
    }
}
