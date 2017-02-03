<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Tel;

class TelTest extends \PHPUnit\Framework\TestCase
{
    /** @var Tel */
    private $control;

    public function setUp()
    {
        $this->control = new Tel('tel');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('tel', $control->getAttribute('type'));
    }
}
