<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Validator;

class NotNull extends AbstractValidator
{
    /** @var string NOT_NULL */
    const NOT_NULL = 'The given value must not be null.';

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
        $this->addError(['value' => $value]);

        return false;
    }
}
