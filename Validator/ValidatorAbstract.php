<?php
namespace Vision\Validator;

class ValidateException extends \Exception {}

abstract class ValidatorAbstract implements ValidatorInterface 
{
	protected $messages = array();
	
	public function setMessage($key, $message) {
		$this->messages[$key] = (string) $message;
		return $this;
	}
    
	public function getMessages() {
		return $this->messages;
	}	
}