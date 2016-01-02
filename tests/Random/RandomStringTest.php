<?php
namespace VisionTest\Random;

use Vision\Random\RandomString;

class RandomStringTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateHex()
    {
        $string = new RandomString();

        $hex = $string->generateHex(10);
        $this->assertInternalType('string', $hex);
        $this->assertSame(10, strlen($hex));
        $this->assertTrue(ctype_xdigit($hex));
    }

    public function testGenerateHexWithInvalidLength()
    {
        $string = new RandomString();

        $hex = $string->generateHex(3);
        $this->assertFalse($hex);

        $hex = $string->generateHex(1);
        $this->assertFalse($hex);
    }
}
