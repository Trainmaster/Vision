<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Url;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->control = new Url('url');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('url', $control->getAttribute('type'));
    }
}
