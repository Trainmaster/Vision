<?php
namespace VisionTest\Html;

use Vision\Html\Element;

class ElementTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructWithValidArgument()
    {
        $element = new Element('h1');
        $this->assertInstanceOf('\Vision\Html\Element', $element);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testContructWhenArgumentIsNoString()
    {
        $element = new Element(1);
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testContructWhenArgumentHasForbiddenCharacters()
    {
        $element = new Element('h1?');
    }

    public function testGetTag()
    {
        $element = new Element('div');
        $this->assertSame('div', $element->getTag());
    }

    public function testVoidElement()
    {
        $element = new Element('area');
        $this->assertTrue($element->isVoid());
    }

    public function testNonVoidElement()
    {
        $element = new Element('div');
        $this->assertFalse($element->isVoid());
    }

    public function testSetAndGetAttributeWithOneArgument()
    {
        $element = new Element('div');

        $this->assertSame(null, $element->getAttribute('required'));
        $this->assertSame($element, $element->setAttribute('required'));
        $this->assertSame(true, $element->getAttribute('required'));
    }

    public function testSetAndGetAttributeWithTwoArguments()
    {
        $element = new Element('div');

        $this->assertSame(null, $element->getAttribute('id'));
        $this->assertSame($element, $element->setAttribute('id', 'foo'));
        $this->assertSame('foo', $element->getAttribute('id'));
    }

    public function testSetAndGetAttributes()
    {
        $attr = array(
            'required' => true,
            'id' => 'foo'
        );

        $element = new Element('div');

        $this->assertSame(array(), $element->getAttributes());
        $this->assertSame($element, $element->setAttributes($attr));
        $this->assertSame($attr, $element->getAttributes());
    }

    public function testRemoveAttribute()
    {
        $element = new Element('div');

        $this->assertFalse($element->removeAttribute('id'));

        $element->setAttribute('id', 'foo');

        $this->assertSame('foo', $element->getAttribute('id'));
        $this->assertTrue($element->removeAttribute('id'));
        $this->assertSame(null, $element->getAttribute('id'));
    }

    public function testAddAndGetContents()
    {
        $element = new Element('div');

        $this->assertSame(array(), $element->getContents());
        $this->assertSame($element, $element->addContent('Hello World'));
        $this->assertSame(array('Hello World'), $element->getContents());

        $content = new Element('p');

        $this->assertSame($element, $element->addContent($content));
        $this->assertSame(array('Hello World', $content), $element->getContents());

        $this->assertSame($element, $element->addContent(null));
        $this->assertSame(array('Hello World', $content), $element->getContents());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddContentWhenArgumentIsArray()
    {
        $element = new Element('div');

        $element->addContent(array());
    }

    /**
     * @expectedException LogicException
     */
    public function testAddContentWhenElementIsVoid()
    {
        $element = new Element('area');

        $element->addContent('foo');
    }

    public function testClearContents()
    {
        $element = new Element('div');

        $element->addContent('foo');

        $this->assertSame(array('foo'), $element->getContents());
        $this->assertSame($element, $element->clearContents());
        $this->assertSame(array(), $element->getContents());
    }
}
