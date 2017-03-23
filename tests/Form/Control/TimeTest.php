<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Time;

use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    /** @var Time */
    private $control;

    public function setUp()
    {
        $this->control = new Time('time');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('time', $control->getAttribute('type'));
    }

    public function testDateTimeAsValue()
    {
        $control = $this->control;

        $dateTime = new \DateTime('12:00');

        $control->setValue($dateTime);

        $this->assertSame('12:00', $control->getAttribute('value'));
        $this->assertSame($dateTime, $control->getValue());

        $control->setTimeFormat('H:i:s');
        $control->setValue($dateTime);

        $this->assertSame('12:00:00', $control->getAttribute('value'));
        $this->assertSame($dateTime, $control->getValue());
    }
}
