<?php
namespace Vision\Validator;

interface ValidatorInterface
{
    public function isValid($value);

    public function addError($error);

    public function getErrors();
}
