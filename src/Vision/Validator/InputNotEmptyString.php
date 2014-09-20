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
 * InputNotEmptyString
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class InputNotEmptyString extends AbstractValidator
{
    /** @type string INPUT_NOT_EMPTY_STRING */
    const INPUT_NOT_EMPTY_STRING = 'The given value contains an empty string.';

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

        if (is_string($value) && $value !== '') {
            return true;
        }

        if (is_array($value)) {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($value));

            $count = iterator_count($iterator);

            if ($count === 0) {
                return true;
            }

            foreach ($iterator as $leaf) {
                if (!is_string($leaf)) {
                    continue;
                }

                if ($leaf !== '') {
                    continue;
                }

                goto error;
            }

            return true;
        }

        if (!is_string($value)) {
            return true;
        }

        error:

        $this->addError(self::INPUT_NOT_EMPTY_STRING);

        return false;
    }
}
