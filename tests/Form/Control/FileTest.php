<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /** @var File */
    private $control;

    public function setUp(): void
    {
        $this->control = new File('file');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('file', $control->getAttribute('type'));
    }
}
