<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\AbstractInput;
use PHPUnit\Framework\TestCase;

class AbstractInputTest extends TestCase
{
    /** @var AbstractInput */
    private $control;

    public function setUp()
    {
        $this->control = $this->getMockForAbstractClass('\Vision\Form\Control\AbstractInput', ['abstract']);
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractControl', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('input', $control->getTag());
        $this->assertTrue($control->isRequired());
    }
}
