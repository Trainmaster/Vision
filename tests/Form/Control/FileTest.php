<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\File;

class FileTest extends \PHPUnit_Framework_TestCase
{
    /** @var File */
    private $control;

    public function setUp()
    {
        $this->control = new File('file');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('file', $control->getAttribute('type'));
    }
}
