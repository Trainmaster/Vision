<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\Password;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    /** @var Password */
    private $control;

    protected function setUp(): void
    {
        $this->control = new Password('password');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('password', $control->getAttribute('type'));
    }
}
