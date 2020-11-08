<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\AbstractControl;
use LogicException;
use PHPUnit\Framework\TestCase;

class AbstractControlTest extends TestCase
{
    /** @var AbstractControl */
    private $control;

    public function setUp(): void
    {
        $this->control = $this->getMockForAbstractClass('\Vision\Form\Control\AbstractControl', ['abstract']);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertNull($control->getLabel());
        $this->assertNull($control->getPlaceholder());
        $this->assertFalse($control->isRequired());
        $this->assertNull($control->getData());
        $this->assertNull($control->getValue());
        $this->assertSame([], $control->getFilters());
        $this->assertSame([], $control->getErrors());
        $this->assertFalse($control->hasChildren());
        $this->assertSame([], $control->getChildren());
    }

    public function testIsValidLoopException()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('The element may only be validated once per life-cycle.');
        $control = $this->control;

        $control->isValid();
        $control->isValid();
    }

    public function testNullData()
    {
        $control = $this->control;

        $this->assertTrue($control->isValid());
        $this->assertNull($control->getValue());
        $this->assertEmpty($control->getErrors());
    }

    public function testNullDataWhenIsRequired()
    {
        $control = $this->control;
        $control->setRequired(true);

        $this->assertFalse($control->isValid());
        $this->assertNull($control->getValue());
        $this->assertNotEmpty($control->getErrors());
    }

    public function testEmptyStringData()
    {
        $control = $this->control;
        $control->setData('');

        $this->assertTrue($control->isValid());
        $this->assertSame('', $control->getValue());
        $this->assertEmpty($control->getErrors());
    }

    public function testEmptyStringDataWhenIsRequired()
    {
        $control = $this->control;
        $control->setRequired(true);
        $control->setData('');

        $this->assertFalse($control->isValid());
        $this->assertNull($control->getValue());
        $this->assertNotEmpty($control->getErrors());
    }

    public function testZeroAsStringData()
    {
        $control = $this->control;
        $control->setData('0');

        $this->assertTrue($control->isValid());
        $this->assertSame('0', $control->getValue());
        $this->assertEmpty($control->getErrors());
    }

    public function testZeroAsStringDataWhenIsRequired()
    {
        $control = $this->control;
        $control->setRequired(true);
        $control->setData('0');

        $this->assertTrue($control->isValid());
        $this->assertSame('0', $control->getValue());
        $this->assertEmpty($control->getErrors());
    }
}
