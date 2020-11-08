<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\Color;
use PHPUnit\Framework\TestCase;

class ColorTest extends TestCase
{
    /** @var Color */
    private $control;

    public function setUp(): void
    {
        $this->control = new Color('color');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('color', $control->getAttribute('type'));
    }
}
