<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Range;

class RangeTest extends \PHPUnit\Framework\TestCase
{
    /** @var Range*/
    private $control;

    public function setUp()
    {
        $this->control = new Range('range');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('range', $control->getAttribute('type'));
    }
}
