<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\Week;
use PHPUnit\Framework\TestCase;

class WeekTest extends TestCase
{
    /** @var Week */
    private $control;

    public function setUp(): void
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
