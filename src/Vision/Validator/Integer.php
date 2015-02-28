<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Validator;

/**
 * Integer
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Integer extends AbstractValidator
{
    /** @var string NO_INTEGER */
    const NO_INTEGER = 'The given value is not an integer.';

    /**
     * @api
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        $this->resetErrors();

        if (is_int($value)) {
            return true;
        }

        $this->addError(self::NO_INTEGER);

        return false;
    }
}
