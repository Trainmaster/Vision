<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Email;

class EmailTest extends \PHPUnit_Framework_TestCase
{
    /** @var Email */
    private $control;

    public function setUp()
    {
        $this->control = new Email('email');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('email', $control->getAttribute('type'));
        $this->assertContainsOnlyInstancesOf('Vision\Validator\Email', $control->getValidators());
    }
}
