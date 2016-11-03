<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Week;

class WeekTest extends \PHPUnit_Framework_TestCase
{
    /** @var Week */
    private $control;

    public function setUp()
    {
        $this->control = new Week('week');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('week', $control->getAttribute('type'));
    }
}
