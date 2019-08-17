<?php
namespace VisionTest\DataStructures\Arrays\Mutator;

use Vision\DataStructures\Arrays\Mutator\SquareBracketNotation;

use PHPUnit\Framework\TestCase;

class SquareBracketNotationTest extends TestCase
{
    public function testSet()
    {
        $mutator = new SquareBracketNotation([]);

        $mutator->set('foo', '1');
        $mutator->set('bar[baz]', '2');
        $mutator->set('baz[foo][bar]', '3');

        $this->assertSame('1', $mutator->get('foo'));
        $this->assertSame('2', $mutator->get('bar[baz]'));
        $this->assertSame('3', $mutator->get('baz[foo][bar]'));
    }

    public function testSetWithIllegalStringOffset()
    {
        $mutator = new SquareBracketNotation([]);

        $mutator->set('foo[bar]', 2);
        $mutator->set('foo', 1);

        $this->assertSame(['foo' => 1], $mutator->getArrayCopy());


        $mutator->set('foo', 1);
        $mutator->set('foo[bar]', 2);

        $this->assertSame(['foo' => 1], $mutator->getArrayCopy());
    }

    public function testGetWithEmptyArray()
    {
        $mutator = new SquareBracketNotation([]);

        $this->assertNull($mutator->get('0'));
        $this->assertNull($mutator->get('foo'));
        $this->assertNull($mutator->get('foo[]'));
        $this->assertNull($mutator->get('foo[bar]'));
        $this->assertNull($mutator->get('foo[bar][]'));
    }

    public function testGetWithOneDimensionalArray()
    {
        $mutator = new SquareBracketNotation(['foo' => 'bar', 'baz']);

        $this->assertSame('bar', $mutator->get('foo'));
        $this->assertSame('baz', $mutator->get('0'));
    }

    public function testGetWithMultiDimensionalArray()
    {
        $mutator = new SquareBracketNotation(['foo' => ['bar' => 'baz']]);

        $this->assertSame('baz', $mutator->get('foo[bar]'));
    }

    public function testGetArrayCopy()
    {
        $mutator = new SquareBracketNotation([]);
        $this->assertEmpty($mutator->getArrayCopy());

        $mutator = new SquareBracketNotation(['foo' => 'bar']);
        $this->assertSame(['foo' => 'bar'], $mutator->getArrayCopy());
    }
}
