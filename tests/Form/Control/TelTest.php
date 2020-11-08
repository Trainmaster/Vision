<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\Tel;
use PHPUnit\Framework\TestCase;

class TelTest extends TestCase
{
    /** @var Tel */
    private $control;

    public function setUp(): void
    {
        $this->control = new Tel('tel');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('tel', $control->getAttribute('type'));
    }
}
