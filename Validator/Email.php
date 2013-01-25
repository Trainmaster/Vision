<?php
namespace Vision\Validator;

class Email extends ValidatorAbstract 
{
    public function isValid($email) 
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $message = sprintf('"%s" is not a valid e-mail address.', $email);
            $this->setMessage('Email', $message);    
            return false;
        }
        return true;
    }
}