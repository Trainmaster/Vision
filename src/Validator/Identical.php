<?php
namespace Vision\Validator;

class Identical extends AbstractValidator
{
    /** @var string NOT_IDENTICAL */
    const NOT_IDENTICAL = 'The given operands are not identical.';

    /** @var mixed $operand */
    protected $operand;

    /**
     * @param mixed $operand
     */
    public function __construct($operand = null)
    {
        $this->setOperand($operand);
    }

    /**
     * @param mixed $operand
     *
     * @return $this Provides a fluent interface.
     */
    public function setOperand($operand)
    {
        $this->operand = $operand;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOperand()
    {
        return $this->operand;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        $this->resetErrors();

        if ($value === $this->operand) {
            return true;
        }

        $this->addError(self::NOT_IDENTICAL);
        $this->addError([
            'operand1' => $value,
            'operand2' => $this->operand
        ]);

        return false;
    }
}
