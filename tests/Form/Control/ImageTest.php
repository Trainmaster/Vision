<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    /** @var Image */
    private $control;

    protected function setUp(): void
    {
        $this->control = new Image('image');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('image', $control->getAttribute('type'));
    }
}
