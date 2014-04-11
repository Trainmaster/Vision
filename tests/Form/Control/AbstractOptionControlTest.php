<?php
namespace VisionTest\Form\Control;

class AbstractOptionControlTest extends \PHPUnit_Framework_TestCase
{
    protected $defaultOptions = array(
        1 => 'foo',
        2 => 'bar',
        3 => 'baz'
    );

    public function setUp()
    {
        $this->control = $this->getMockForAbstractClass('\Vision\Form\Control\AbstractOptionControl', array('abstract'));
    }

    public function testAfterConstruct()
    {
        $control = $this->control;

        $this->assertNull($control->getData());
        $this->assertSame(array(), $control->getOptions());
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
        $this->assertSame(array('foo' => 'bar'), $control->getOptions());
    }

    public function testSetOptions()
    {
        $control = $this->control;

        $this->assertSame($control, $control->setOptions(array(1 => 'foo', 2 => 'bar', 3 => 'baz')));

        return $control;
    }

    /**
     * @depends testSetOptions
     */
    public function testGetOptionsAfterSetOptions($control)
    {
        $this->assertSame(array(1 => 'foo', 2 => 'bar', 3 => 'baz'), $control->getOptions());
    }

    public function testIsValidWithoutDataAndOptions()
    {
        $control = $this->control;

        $this->assertTrue($control->isValid());
    }

    public function testIsValidWithDataAndWithoutOptions()
    {
        $control = $this->control;

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

    public function testIsValidWithComplexDataAndOptions()
    {
        $control = $this->control;

        $control->setData(array(1, 2, 3));
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

    public function testIsValidWithComplexPartialInvalidDataAndOptions()
    {
        $control = $this->control;

        $control->setData(array(1, 2, 4));
        $control->setOptions($this->defaultOptions);

        $this->assertFalse($control->isValid());
    }

    public function testIsValidWithoutDataAndWithOptions()
    {
        $control = $this->control;

        $control->setOptions($this->defaultOptions);

        $this->assertTrue($control->isValid());
    }
}
