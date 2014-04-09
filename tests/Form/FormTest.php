<?php
use Vision\Form\Form;

class FormTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->form = new Form('form');
    }

    public function testMethodsWhenConstructing()
    {
        $this->assertInstanceOf('RecursiveIteratorIterator', $this->form->getIterator());
        $this->assertSame('', $this->form->getAction());
        $this->assertSame('post', $this->form->getMethod());
        $this->assertTrue($this->form->isMethod('post'));
        $this->assertSame(array(), $this->form->getData());
        $this->assertSame(array(), $this->form->getValues());
        $this->assertSame(array(), $this->form->getErrors());
    }

    public function testSetAndGetAction()
    {
        $this->assertSame($this->form, $this->form->setAction('foo'));
        $this->assertSame('foo', $this->form->getAction());
    }

    public function testSetAndGetMethod()
    {
        $this->assertSame($this->form, $this->form->setMethod('get'));
        $this->assertSame('get', $this->form->getMethod());
    }

    public function testIsMethodCaseInsensitivity()
    {

        $this->assertTrue($this->form->isMethod('PoSt'));
        $this->assertTrue($this->form->isMethod('POST'));
    }

    public function testIsMethodWithInvalidMethod()
    {
        $this->assertTrue($this->form->isMethod('post'));
        $this->assertFalse($this->form->isMethod('HEAD'));
    }

    public function testSetAndGetData()
    {
        $this->assertSame($this->form, $this->form->setData(array('foo' => 'bar')));
        $this->assertSame(array('foo' => 'bar'), $this->form->getData());
    }

    public function testSetAndGetValues()
    {
        $this->assertSame($this->form, $this->form->setValues(array('foo' => 'bar')));
        $this->assertSame(array(), $this->form->getValues());
    }

    public function testSetOptions()
    {
        $this->assertSame($this->form, $this->form->setOptions(array('foo' => 'bar')));
    }
}
