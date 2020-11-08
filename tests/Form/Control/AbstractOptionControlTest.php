<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\AbstractOptionControl;
use PHPUnit\Framework\TestCase;

class AbstractOptionControlTest extends TestCase
{
    /** @var AbstractOptionControl */
    private $control;

    protected $defaultOptions = [
        1 => 'foo',
        2 => 'bar',
        3 => 'baz'
    ];

    protected function setUp(): void
    {
        $this->control = $this->getMockForAbstractClass('\Vision\Form\Control\AbstractOptionControl', ['abstract']);
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractControl', $control);
    }

    public function testAfterConstruct()
    {
        $control = $this->control;

        $this->assertNull($control->getData());
        $this->assertSame([], $control->getOptions());
    }

    public function testSetOption()
    {
        $control = $this->control;

        $this->assertSame($control, $control->setOption('foo', 'bar'));

        return $control;
    }

    /**
     * @depends testSetOption
     */
    public function testGetOptionsAfterSetOption($control)
    {
        $this->assertSame(['foo' => 'bar'], $control->getOptions());
    }

    public function testSetOptions()
    {
        $control = $this->control;

        $this->assertSame($control, $control->setOptions([1 => 'foo', 2 => 'bar', 3 => 'baz']));

        return $control;
    }

    /**
     * @depends testSetOptions
     */
    public function testGetOptionsAfterSetOptions($control)
    {
        $this->assertSame([1 => 'foo', 2 => 'bar', 3 => 'baz'], $control->getOptions());
    }

    public function testIsValidWithoutDataAndOptions()
    {
        $control = $this->control;

        $this->assertTrue($control->isValid());
    }

    public function testIsValidWithoutDataAndOptionsWhenIsRequired()
    {
        $control = $this->control;
        $control->setRequired(true);

        $this->assertFalse($control->isValid());
    }

    public function testIsValidWithDataAndWithoutOptions()
    {
        $control = $this->control;

        $control->setData(1);

        $this->assertFalse($control->isValid());
    }

    public function testIsValidWithDataAndWithoutOptionsWhenIsRequired()
    {
        $control = $this->control;
        $control->setRequired(true);

        $control->setData(1);

        $this->assertFalse($control->isValid());
    }

    public function testIsValidWithDataAndOptions()
    {
        $control = $this->control;

        $control->setData(1);
        $control->setOptions($this->defaultOptions);

        $this->assertTrue($control->isValid());
    }

    public function testIsValidWithDataAndOptionsWhenIsRequired()
    {
        $control = $this->control;
        $control->setRequired(true);

        $control->setData(1);
        $control->setOptions($this->defaultOptions);

        $this->assertTrue($control->isValid());
    }

    public function testIsValidWithComplexDataAndOptions()
    {
        $control = $this->control;

        $control->setData([1, 2, 3]);
        $control->setOptions($this->defaultOptions);

        $this->assertTrue($control->isValid());
    }

    public function testIsValidWithComplexDataAndOptionsWhenIsRequired()
    {
        $control = $this->control;
        $control->setRequired(true);

        $control->setData([1, 2, 3]);
        $control->setOptions($this->defaultOptions);

        $this->assertTrue($control->isValid());
    }

    public function testIsValidWithInvalidDataAndOptions()
    {
        $control = $this->control;

        $control->setData(4);
        $control->setOptions($this->defaultOptions);

        $this->assertFalse($control->isValid());
    }

    public function testIsValidWithInvalidDataAndOptionsWhenIsRequired()
    {
        $control = $this->control;
        $control->setRequired(true);

        $control->setData(4);
        $control->setOptions($this->defaultOptions);

        $this->assertFalse($control->isValid());
    }

    public function testIsValidWithComplexPartialDataAndOptions()
    {
        $control = $this->control;

        $control->setData([1, 3]);
        $control->setOptions($this->defaultOptions);

        $this->assertTrue($control->isValid());
    }

    public function testIsValidWithComplexPartialDataAndOptionsWhenIsRequired()
    {
        $control = $this->control;
        $control->setRequired(true);

        $control->setData([1, 3]);
        $control->setOptions($this->defaultOptions);

        $this->assertTrue($control->isValid());
    }

    public function testIsValidWithComplexPartialInvalidDataAndOptions()
    {
        $control = $this->control;

        $control->setData([1, 2, 4]);
        $control->setOptions($this->defaultOptions);

        $this->assertFalse($control->isValid());
    }

    public function testIsValidWithComplexPartialInvalidDataAndOptionsWhenIsRequired()
    {
        $control = $this->control;
        $control->setRequired(true);

        $control->setData([1, 2, 4]);
        $control->setOptions($this->defaultOptions);

        $this->assertFalse($control->isValid());
    }

    public function testIsValidWithoutDataAndWithOptions()
    {
        $control = $this->control;

        $control->setOptions($this->defaultOptions);

        $this->assertTrue($control->isValid());
    }

    public function testIsValidWithoutDataAndWithOptionsWhenIsRequired()
    {
        $control = $this->control;
        $control->setRequired(true);

        $control->setOptions($this->defaultOptions);

        $this->assertFalse($control->isValid());
    }
}
