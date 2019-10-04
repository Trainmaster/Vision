<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\DateTimeLocal;
use PHPUnit\Framework\TestCase;

class DateTimeLocalTest extends TestCase
{
    /** @var DateTimeLocal */
    private $control;

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
