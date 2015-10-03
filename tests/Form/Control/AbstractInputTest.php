<?php
namespace VisionTest\Form\Control;

class AbstractInputTest extends \PHPUnit_Framework_TestCase
{
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
