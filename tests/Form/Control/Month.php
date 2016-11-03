<?php
use Vision\Form\Control\Month;

class MonthTest extends \PHPUnit_Framework_TestCase
{
    /** @var Month*/
    private $control;

    public function setUp()
    {
        $this->control = new Month('month');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('month', $control->getAttribute('type'));
    }
}
