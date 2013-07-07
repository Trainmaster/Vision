<?php
namespace Vision\Validator;

class InputNotEmptyString extends ValidatorAbstract 
{   
    const NO_EMPTY_STRING = 'The given string is not empty.';
    
    public function isValid($value)
    {
        $value = filter_var($value, FILTER_UNSAFE_RAW, array('flags' => FILTER_FLAG_EMPTY_STRING_NULL));
        
        if ($value !== false || $value !== null) {
            return true;
        }
        
        $this->addError(self::NO_EMPTY_STRING);
        
        return false;
    }
}