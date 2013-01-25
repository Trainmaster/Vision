<?php
namespace Vision\Validator;

class NotEmptyString extends ValidatorAbstract 
{	
    public function isValid($value)
    {
        $value = (string) $value;
        if ($value === '') {
            $this->setMessage('NotEmptyString', 'Field must not be empty.');
            return false;
        }
        return true;
    }
}