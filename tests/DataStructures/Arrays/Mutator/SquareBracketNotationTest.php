<?php
use Vision\DataStructures\Arrays\Mutator\SquareBracketNotation;

class SquareBracketNotationTest extends \PHPUnit_Framework_TestCase
{
    public function testSet()
    {
        $mutator = new SquareBracketNotation(array());

        $mutator->set('foo', '1');
        $mutator->set('bar[baz]', '2');
        $mutator->set('baz[foo][bar]', '3');

        $this->assertSame('1', $mutator->get('foo'));
        $this->assertSame('2', $mutator->get('bar[baz]'));
        $this->assertSame('3', $mutator->get('baz[foo][bar]'));
    }

    public function testSetWithIllegalStringOffset()
    {
        $mutator = new SquareBracketNotation(array());

        $mutator->set('foo[bar]', 2);
        $mutator->set('foo', 1);

        $this->assertSame(array('foo' => 1), $mutator->getArrayCopy());


        $mutator->set('foo', 1);
        $mutator->set('foo[bar]',2);

        $this->assertSame(array('foo' => 1), $mutator->getArrayCopy());
    }

    public function testGetWithEmptyArray()
    {
        $mutator = new SquareBracketNotation(array());

        $this->assertNull($mutator->get('0'));
        $this->assertNull($mutator->get('foo'));
        $this->assertNull($mutator->get('foo[]'));
        $this->assertNull($mutator->get('foo[bar]'));
        $this->assertNull($mutator->get('foo[bar][]'));
    }

    public function testGetWithOneDimensionalArray()
    {
        $mutator = new SquareBracketNotation(array('foo' => 'bar', 'baz'));

        $this->assertSame('bar', $mutator->get('foo'));
        $this->assertSame('baz', $mutator->get('0'));
    }

    public function testGetWithMultiDimensionalArray()
    {
        $mutator = new SquareBracketNotation(array('foo' => array('bar' => 'baz')));

        $this->assertSame('baz', $mutator->get('foo[bar]'));
    }

    public function testGetArrayCopy()
    {
        $mutator = new SquareBracketNotation(array());
        $this->assertEmpty($mutator->getArrayCopy());

        $mutator = new SquareBracketNotation(array('foo' => 'bar'));
        $this->assertSame(array('foo' => 'bar'), $mutator->getArrayCopy());
    }
}
