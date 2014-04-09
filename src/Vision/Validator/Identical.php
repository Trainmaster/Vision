<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Validator;

/**
 * Identical
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Identical extends AbstractValidator
{
    /** @type string NOT_IDENTICAL */
    const NOT_IDENTICAL = 'The given operands are not identical.';

    /** @type mixed $operand */
    protected $operand = null;

    /**
     * @param mixed $operand
     */
    public function __construct($operand = null)
    {
        $this->setOperand($operand);
    }

    /**
     * @api
     *
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
     * @api
     *
     * @return mixed
     */
    public function getOperand()
    {
        return $this->operand;
    }

    /**
     * @api
     *
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
        $this->addError(array(
            'operand1' => $value,
            'operand2' => $this->operand
        ));

        return false;
    }
}
