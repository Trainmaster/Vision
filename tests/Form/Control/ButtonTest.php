<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Button;

use PHPUnit\Framework\TestCase;

class ButtonTest extends TestCase
{
    /** @var Button */
    private $control;

    public function setUp()
    {
        $this->control = new Button('button');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractControl', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('button', $control->getTag());
        $this->assertTrue($control->isRequired());
    }
}
