<?php
declare(strict_types = 1);

namespace Vision\Validator;

class InputNotEmptyString extends AbstractValidator
{
    /** @var string INPUT_NOT_EMPTY_STRING */
    const INPUT_NOT_EMPTY_STRING = 'The given value contains an empty string.';

    /**
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
