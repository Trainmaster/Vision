<?php

declare(strict_types=1);

namespace Vision\Validator;

class Identical extends AbstractValidator
{
    /** @var mixed $operand */
    protected $operand;

    /** @var string NOT_IDENTICAL */
    private const NOT_IDENTICAL = 'The given operands are not identical.';

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
    public function setOperand($operand): self
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
    public function validate($value): bool
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
