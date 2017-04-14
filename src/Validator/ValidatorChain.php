<?php
declare(strict_types = 1);

namespace Vision\Validator;

class ValidatorChain
{
    /** @var ValidatorInterface[] $validators */
    protected $validators = [];

    /**
     * @param ValidatorInterface $validator
     *
     * @return ValidatorChain Provides a fluent interface.
     */
    public function add(ValidatorInterface $validator)
    {
        $this->validators[] = $validator;
        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function validate($value)
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
