<?php

namespace VisionTest\Validator;

use Vision\Validator;
use PHPUnit\Framework\TestCase;

class InArrayTest extends TestCase
{
    /** @var Validator\InArray */
    protected $validator;

    /** @var Validator\InArray */
    protected $strictValidator;

    protected $haystack = [
        'foo',
        'bar',
        true
    ];

    protected function setUp(): void
    {
        $this->strictValidator = new Validator\InArray($this->haystack);
        $this->validator = new Validator\InArray($this->haystack, false);
    }

    public function testSuccess()
    {
        $this->assertTrue($this->validator->validate(1));
        $this->assertTrue($this->validator->validate('1'));
        $this->assertTrue($this->validator->validate(true));
        $this->assertTrue($this->validator->validate('foo'));
        $this->assertTrue($this->validator->validate(['foo', 'bar']));
        $this->assertTrue($this->validator->validate('baz'));
        $this->assertTrue($this->validator->validate(['baz']));
    }

    public function testFailure()
    {
        $this->assertFalse($this->strictValidator->validate(1));
        $this->assertFalse($this->strictValidator->validate('1'));
        $this->assertFalse($this->strictValidator->validate('baz'));
        $this->assertFalse($this->strictValidator->validate(['baz']));
    }
}
