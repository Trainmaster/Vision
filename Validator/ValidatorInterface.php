<?php
namespace Vision\Validator;

interface ValidatorInterface 
{
    public function isValid($mixed);
    
    public function setMessage($key, $value);
    
    public function getMessages();	
}