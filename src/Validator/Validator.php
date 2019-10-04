<?php
declare(strict_types=1);

namespace Vision\Validator;

interface Validator
{
    public function validate($value): bool;

    public function addError($error): Validator;

    public function getErrors();
}
