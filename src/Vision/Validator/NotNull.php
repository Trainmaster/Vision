<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Validator;

/**
 * NotNull
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class NotNull extends AbstractValidator
{
    /** @type string NOT_NULL */
    const NOT_NULL = 'The given value is not null.';

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

        if ($value !== null) {
            return true;
        }

        $this->addError(self::NOT_NULL);
        $this->addError(array('value' => $value));

        return false;
    }
}
