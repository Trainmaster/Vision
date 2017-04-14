<?php
declare(strict_types = 1);

namespace Vision\Validator;

interface Validator
{
    public function validate($value);

    public function addError($error);

    public function getErrors();
}
