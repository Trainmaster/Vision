<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    /** @var Url */
    private $control;

    public function setUp(): void
    {
        $this->control = new Url('url');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('url', $control->getAttribute('type'));
    }
}
