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

    protected function setUp()
    {
        $this->strictValidator = new Validator\InArray($this->haystack);
        $this->validator = new Validator\InArray($this->haystack, false);
    }

    public function testSuccess()
    {
        $this->assertTrue($this->validator->isValid(1));
        $this->assertTrue($this->validator->isValid('1'));
        $this->assertTrue($this->validator->isValid(true));
        $this->assertTrue($this->validator->isValid('foo'));
        $this->assertTrue($this->validator->isValid(['foo', 'bar']));
        $this->assertTrue($this->validator->isValid('baz'));
        $this->assertTrue($this->validator->isValid(['baz']));
    }

    public function testFailure()
    {
        $this->assertFalse($this->strictValidator->isValid(1));
        $this->assertFalse($this->strictValidator->isValid('1'));
        $this->assertFalse($this->strictValidator->isValid('baz'));
        $this->assertFalse($this->strictValidator->isValid(['baz']));
    }
}
