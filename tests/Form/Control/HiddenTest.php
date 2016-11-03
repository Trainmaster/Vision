<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Hidden;

class HiddenTest extends \PHPUnit_Framework_TestCase
{
    /** @var Hidden */
    private $control;

    public function setUp()
    {
        $this->control = new Hidden('hidden');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('hidden', $control->getAttribute('type'));
    }
}
