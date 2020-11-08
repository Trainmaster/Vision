<?php

namespace VisionTest\Form;

use Vision\Form\Form;
use PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{
    /** @var Form */
    private $form;

    protected function setUp(): void
    {
        $this->form = new Form('form');
    }

    public function testDefaultsAfterConstruct()
    {
        $this->assertInstanceOf('RecursiveIteratorIterator', $this->form->getIterator());
        $this->assertSame('', $this->form->getAction());
        $this->assertSame('post', $this->form->getMethod());
        $this->assertTrue($this->form->isMethod('post'));
        $this->assertSame([], $this->form->getData());
        $this->assertSame([], $this->form->getValues());
        $this->assertSame([], $this->form->getErrors());
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
        $this->assertSame($this->form, $this->form->setData(['foo' => 'bar']));
        $this->assertSame(['foo' => 'bar'], $this->form->getData());
    }

    public function testSetAndGetValues()
    {
        $this->assertSame($this->form, $this->form->setValues(['foo' => 'bar']));
        $this->assertSame([], $this->form->getValues());
    }

    public function testSetOptions()
    {
        $this->assertSame($this->form, $this->form->setOptions(['foo' => 'bar']));
    }
}
