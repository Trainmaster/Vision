<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    /** @var Email */
    private $control;

    protected function setUp(): void
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
