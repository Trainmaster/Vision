<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\Hidden;
use PHPUnit\Framework\TestCase;

class HiddenTest extends TestCase
{
    /** @var Hidden */
    private $control;

    public function setUp()
    {
        $this->control = new Hidden('hidden');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('hidden', $control->getAttribute('type'));
    }
}
