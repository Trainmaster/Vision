<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\Text;
use PHPUnit\Framework\TestCase;

class TextTest extends TestCase
{
    /** @var Text */
    private $control;

    protected function setUp(): void
    {
        $this->control = new Text('text');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('text', $control->getAttribute('type'));
    }
}
