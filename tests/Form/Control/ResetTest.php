<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\Reset;
use PHPUnit\Framework\TestCase;

class ResetTest extends TestCase
{
    /** @var Reset */
    private $control;

    public function setUp()
    {
        $this->control = new Reset('reset');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('reset', $control->getAttribute('type'));
    }
}
