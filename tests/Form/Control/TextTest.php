<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Text;

class TextTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
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