<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Textarea;

class TextareaTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->control = new Textarea('textarea');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractControl', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('textarea', $control->getTag());
    }

    public function testSetRows()
    {
        $control = $this->control;

        $this->assertSame($control, $control->setRows(1));
    }

    public function testSetCols()
    {
        $control = $this->control;

        $this->assertSame($control, $control->setCols(1));
    }

    public function testSetValue()
    {
        $control = $this->control;

        $this->assertSame($control, $control->setValue('foo'));
        $this->assertSame(['foo'], $control->getContents());
    }
    
    public function testSetValueAfterValidatingWithValueAndData()
    {
        $control = $this->control;
        $control->setValue('foo');
        $control->setData('bar');
        $control->isValid();

        $this->assertSame('bar', $control->getValue('foo'));
        $this->assertSame(['bar'], $control->getContents());
    }
}
