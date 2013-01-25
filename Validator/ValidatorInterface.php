<?php
namespace Vision\Validator;

interface ValidatorInterface 
{
    public function isValid($mixed);
    
    public function getMessages();	
}