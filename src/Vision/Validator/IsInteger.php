<?php
namespace Vision\Validator;

class IsInteger extends AbstractValidator 
{
    const NO_INTEGER = 'The given value is not an integer.';
    
    public function isValid($value) 
    {
        if (is_int($value)) {  
            return true;
        }        
        
        $this->addError(self::NO_INTEGER);
        
        return false;
    }
}