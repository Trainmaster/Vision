<?php
namespace VisionTest\Random;

use Vision\Random\String;

class StringTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateHex()
    {
        $string = new String();

        $hex = $string->generateHex(10);
        $this->assertInternalType('string', $hex);
        $this->assertSame(10, strlen($hex));
        $this->assertTrue(ctype_xdigit($hex));
    }

    public function testGenerateHexWithInvalidLength()
    {
        $string = new String();

        $hex = $string->generateHex(3);
        $this->assertFalse($hex);

        $hex = $string->generateHex(1);
        $this->assertFalse($hex);
    }
}
