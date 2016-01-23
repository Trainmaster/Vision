<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
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
