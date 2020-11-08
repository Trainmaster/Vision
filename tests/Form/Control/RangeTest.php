<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\Range;
use PHPUnit\Framework\TestCase;

class RangeTest extends TestCase
{
    /** @var Range*/
    private $control;

    public function setUp(): void
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
