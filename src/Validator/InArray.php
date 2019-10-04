<?php

declare(strict_types=1);

namespace Vision\Validator;

class InArray extends AbstractValidator
{
    /** @var array $haystack */
    protected $haystack = [];

    /** @var string VALUE_NOT_FOUND */
    private const VALUE_NOT_FOUND = 'Value could not be found.';

    /** @var bool $strict */
    protected $strict = false;

    /**
     * @param array $haystack
     * @param bool $strict
     */
    public function __construct(array $haystack, $strict = true)
    {
        $this->haystack = $haystack;
        $this->strict = (bool) $strict;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function validate($value): bool
    {
        $this->resetErrors();

        if ($value === null) {
            return true;
        }

        if (is_array($value)) {
            $result = array_diff($value, $this->haystack);
            if (empty($result)) {
                return true;
            }
        }

        if (in_array($value, $this->haystack, $this->strict)) {
            return true;
        }

        $this->addError(self::VALUE_NOT_FOUND);
        $this->addError([
            'needle'   => $value,
            'haystack' => $this->haystack,
            'strict'   => $this->strict
        ]);

        return false;
    }
}
