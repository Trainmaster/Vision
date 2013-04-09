<?php
namespace Vision\Validator;

class InputNotEmptyString extends ValidatorAbstract 
{   
    public function isValid($value)
    {
        $value = filter_var($value, FILTER_UNSAFE_RAW, array('flags' => FILTER_FLAG_EMPTY_STRING_NULL));
        if ($value === null) {
            $this->setMessage('InputNotEmptyString', 'Field must not be empty.');
            return false;
        }
        return true;
    }
}