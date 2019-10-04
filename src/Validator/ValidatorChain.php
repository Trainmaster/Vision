<?php

declare(strict_types=1);

namespace Vision\Validator;

class ValidatorChain
{
    /** @var Validator[] $validators */
    protected $validators = [];

    /**
     * @param Validator $validator
     *
     * @return ValidatorChain Provides a fluent interface.
     */
    public function add(Validator $validator): self
    {
        $this->validators[] = $validator;
        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function validate($value): bool
    {
        $isValid = true;

        foreach ($this->validators as $validator) {
            $isValid = $validator->validate($value);
            if (!$isValid) {
                break;
            }
        }

        return $isValid;
    }
}
