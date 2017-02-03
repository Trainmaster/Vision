<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Password;

class PasswordTest extends \PHPUnit\Framework\TestCase
{
    /** @var Password */
    private $control;

    public function setUp()
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
