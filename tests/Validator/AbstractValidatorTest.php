<?php
namespace VisionTest\Validator;

use Vision\Validator\AbstractValidator;

use PHPUnit\Framework\TestCase;

class AbstractValidatorTest extends TestCase
{
    /** @var AbstractValidator */
    protected $validator;

    protected function setUp()
    {
        $this->validator = $this->getMockForAbstractClass(AbstractValidator::class);
    }

    public function testGetErrors()
    {
        $this->assertCount(0, $this->validator->getErrors());
        $this->validator->addError('foo');
        $this->assertCount(1, $this->validator->getErrors());
    }

    public function testFluentInterface()
    {
        $this->assertSame($this->validator, $this->validator->addError('foo'));
    }
}
