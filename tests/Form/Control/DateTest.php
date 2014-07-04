<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Date;

use DateTime;

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
        $this->assertSame('Y-m-d', $control->getDateFormat());
    }

    public function testDateTimeAsValue()
    {
        $control = $this->control;

        $dateTime = new \DateTime('2000-01-01');

        $control->setValue($dateTime);

        $this->assertSame('2000-01-01', $control->getAttribute('value'));
        $this->assertSame($dateTime, $control->getValue());

        $control->setDateFormat('d.m.Y');
        $control->setValue($dateTime);

        $this->assertSame('01.01.2000', $control->getAttribute('value'));
        $this->assertSame($dateTime, $control->getValue());
    }

    public function testValidStringAsValue()
    {
        $control = $this->control;

        $control->setValue('2000-01-01');

        $this->assertSame('2000-01-01', $control->getAttribute('value'));
        $this->assertInstanceOf('DateTime', $control->getValue());
    }

    public function testNullAsValue()
    {
        $control = $this->control;

        $control->setValue(null);

        $this->assertSame(null, $control->getAttribute('value'));
        $this->assertSame(null, $control->getValue());
    }

    /**
     * @expectedException Exception
     */
    public function testInvalidStringAsValue()
    {
        $control = $this->control;

        $control->setValue('2000-101-01');
    }
}
