<?php
namespace VisionTest\DataStructures\Arrays;

use Vision\DataStructures\Arrays\ArrayObject;

class ArrayObjectTest extends \PHPUnit_Framework_TestCase
{
    public function testHasInterfacesImplemented()
    {
        $arrayObject = new ArrayObject;

        $this->assertInstanceOf('ArrayAccess', $arrayObject);
        $this->assertInstanceOf('Countable', $arrayObject);
    }

    public function testDefaultsAfterConstruct()
    {
        $arrayObject = new ArrayObject;

        $this->assertSame(array(), $arrayObject->getArrayCopy());
        $this->assertTrue($arrayObject->isEmpty());
    }

    public function testExchangeArray()
    {
        $arrayObject = new ArrayObject;

        $this->assertSame(array(), $arrayObject->exchangeArray(array('foo')));
        $this->assertSame(array('foo'), $arrayObject->getArrayCopy());

        $this->assertSame(array('foo'), $arrayObject->exchangeArray(array()));
        $this->assertSame(array(), $arrayObject->getArrayCopy());
    }


    public function testIsEmpty()
    {
        $arrayObject = new ArrayObject;

        $this->assertTrue($arrayObject->isEmpty());

        $arrayObject->exchangeArray(array('foo'));

        $this->assertFalse($arrayObject->isEmpty());
    }

    public function testIndirectModification()
    {
        $arrayObject = new ArrayObject;

        $this->assertFalse(isset($arrayObject['foo']));
        $arrayObject['foo'] = 'bar';
        $this->assertTrue(isset($arrayObject['foo']));
        $this->assertSame('bar', $arrayObject['foo']);

        $this->assertFalse(isset($arrayObject['bar']['baz']));
        $arrayObject['bar']['baz'] = 'foo';
        $this->assertTrue(isset($arrayObject['bar']['baz']));
        $this->assertSame('foo', $arrayObject['bar']['baz']);

        unset($arrayObject['bar']['baz']);
        $this->assertFalse(isset($arrayObject['bar']['baz']));

        unset($arrayObject['foo']);
        $this->assertFalse(isset($arrayObject['foo']));
    }

    public function testCount()
    {
        $arrayObject = new ArrayObject;

        $this->assertSame(0, count($arrayObject));

        $arrayObject->exchangeArray(array('foo'));

        $this->assertSame(1, count($arrayObject));

        $arrayObject->exchangeArray(array('foo', 'bar', 'baz'));

        $this->assertSame(3, count($arrayObject));

        $arrayObject->exchangeArray(array('foo', 'bar', 'baz', array('Hello', 'World')));

        $this->assertSame(4, count($arrayObject));
    }
}
