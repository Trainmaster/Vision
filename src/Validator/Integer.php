<?php
declare(strict_types=1);

namespace Vision\Validator;

class Integer extends AbstractValidator
{
    /** @var string NO_INTEGER */
    const NO_INTEGER = 'The given value is not an integer.';

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function validate($value): bool
    {
        $this->resetErrors();

        if (is_int($value)) {
            return true;
        }

        $this->addError(self::NO_INTEGER);

        return false;
    }
}
