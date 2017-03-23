<?php
namespace VisionTest\Random;

use Vision\Random\RandomString;

use PHPUnit\Framework\TestCase;

use DomainException;

class RandomStringTest extends TestCase
{
    public function testGenerateHex()
    {
        $hex = RandomString::generateHex(10);
        $this->assertSame(10, strlen($hex));
        $this->assertTrue(ctype_xdigit($hex));
    }

    public function testGenerateHexWithLengthTooSmall()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Length must be greater than or equal to 2.');

        RandomString::generateHex(1);
    }

    public function testGenerateHexWithLengthNotMultipleOfTwo()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Length must be a multiple of 2.');

        RandomString::generateHex(3);
    }
}
