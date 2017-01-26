<?php
declare(strict_types=1);

namespace Vision\Validator;

class NotNull extends AbstractValidator
{
    /** @var string NOT_NULL */
    const NOT_NULL = 'The given value must not be null.';

    /**
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
