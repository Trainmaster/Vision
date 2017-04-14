<?php
declare(strict_types = 1);

namespace Vision\Validator;

abstract class AbstractValidator implements Validator
{
    /** @var array $errors */
    protected $errors = [];

    /**
     * @param mixed $error
     *
     * @return $this Provides a fluent interface.
     */
    public function addError($error)
    {
        $this->errors[] = $error;
        return $this;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return void
     */
    public function resetErrors()
    {
        $this->errors = [];
    }
}
