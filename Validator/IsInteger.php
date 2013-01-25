<?php
namespace Vision\Validator;

class IsInteger extends ValidatorAbstract 
{
	public function isValid($value) 
    {
		if (is_int($value) === true) {	
            return true;
		}        
        $this->setMessage('Integer', 'Value is not an integer');
		return false;
	}
}