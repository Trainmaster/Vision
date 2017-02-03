<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Image;

class ImageTest extends \PHPUnit\Framework\TestCase
{
    /** @var Image */
    private $control;

    public function setUp()
    {
        $this->control = new Image('image');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('image', $control->getAttribute('type'));
    }
}
