<?php
namespace Vision\Validator;

class Email extends ValidatorAbstract 
{
    const INVALID_EMAIL = 'The given e-mail address is not valid.';
    
    public function isValid($email) 
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        
        $this->addError(self::INVALID_EMAIL);   
        
        return false;        
    }
}