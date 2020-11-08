<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\Month;
use PHPUnit\Framework\TestCase;

class MonthTest extends TestCase
{
    /** @var Month*/
    private $control;

    public function setUp(): void
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
