<?php
namespace VisionTest\Html;

use Vision\Html\Element;

use InvalidArgumentException;
use LogicException;

use PHPUnit\Framework\TestCase;

class ElementTest extends TestCase
{
    public function testConstructWithValidTagName()
    {
        $this->assertInstanceOf(Element::class, new Element('h1'));
    }

    public function testConstructWithForbiddenCharacterInTagName()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Invalid tag name "h1?". Only alphanumeric ASCII characters [A-Za-z0-9] are allowed.'
        );

        new Element('h1?');
    }

    public function testConstructWithSpaceInTagName()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Invalid tag name " h1". Only alphanumeric ASCII characters [A-Za-z0-9] are allowed.'
        );

        new Element(' h1');
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

        $this->assertNull($element->getAttribute('required'));
        $this->assertSame($element, $element->setAttribute('required'));
        $this->assertTrue($element->getAttribute('required'));
    }

    public function testSetAndGetAttributeWithTwoArguments()
    {
        $element = new Element('div');

        $this->assertNull($element->getAttribute('id'));
        $this->assertSame($element, $element->setAttribute('id', 'foo'));
        $this->assertSame('foo', $element->getAttribute('id'));
    }

    public function testSetAttributesShouldProvideFluentInterface()
    {
        $element = new Element('div');

        $this->assertSame($element, $element->setAttributes([]));
    }

    public function testGetAttributes()
    {
        $attributes = ['required' => true, 'id' => 'foo'];
        $element = (new Element('div'))->setAttributes($attributes);

        $this->assertSame($attributes, $element->getAttributes());
    }

    public function testRemoveAttribute()
    {
        $element = (new Element('div'))->setAttribute('id', 'foo');

        $this->assertTrue($element->removeAttribute('id'));
    }

    public function testRemoveAttributeIfAttributeWasNotSetBefore()
    {
        $element = new Element('div');

        $this->assertFalse($element->removeAttribute('id'));
    }

    public function testInitializeWithEmptyContents()
    {
        $element = new Element('div');

        $this->assertSame([], $element->getContents());
    }

    public function testAddContentShouldProvideFluentInterface()
    {
        $element = new Element('div');

        $this->assertSame($element, $element->addContent('Hello World'));
    }

    public function testAddAndGetContents()
    {
        $element = new Element('div');

        $element->addContent('Hello World');
        $this->assertSame(['Hello World'], $element->getContents());

        $content = new Element('p');

        $element->addContent($content);
        $this->assertSame(['Hello World', $content], $element->getContents());

        $element->addContent(null);
        $this->assertSame(['Hello World', $content], $element->getContents());
    }

    public function testAddContentWhenArgumentIsArray()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported argument type.');

        (new Element('div'))->addContent([]);
    }

    public function testAddContentWhenElementIsVoid()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Void elements can\'t have any contents.');

        (new Element('area'))->addContent('foo');
    }

    public function testClearContentsShouldProvideFluentInterface()
    {
        $element = new Element('div');

        $this->assertSame($element, $element->clearContents());
    }

    public function testClearContents()
    {
        $element = (new Element('div'))->addContent('foo');

        $element->clearContents();

        $this->assertSame([], $element->getContents());
    }
}
