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
 * Integer
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Integer extends AbstractValidator
{
    /** @type string NO_INTEGER */
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
        if (is_int($value)) {
            return true;
        }

        $this->addError(self::NO_INTEGER);

        return false;
    }
}
