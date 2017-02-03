<?php
namespace VisionTest\Validator;

class AbstractValidatorTest extends \PHPUnit\Framework\TestCase
{
    public function testGetErrors()
    {
        $validator = $this->getMockForAbstractClass('\Vision\Validator\AbstractValidator');

        $this->assertCount(0, $validator->getErrors());
        $validator->addError('foo');
        $this->assertCount(1, $validator->getErrors());
    }

    public function testFluentInterface()
    {
        $validator = $this->getMockForAbstractClass('\Vision\Validator\AbstractValidator');

        $this->assertSame($validator, $validator->addError('foo'));
    }
}
