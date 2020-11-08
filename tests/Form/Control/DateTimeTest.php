<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\DateTime;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{
    /** @var DateTime */
    private $control;

    public function setUp(): void
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
