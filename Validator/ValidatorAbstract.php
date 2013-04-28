<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Validator;

abstract class ValidatorAbstract implements ValidatorInterface 
{
    protected $messages = array();
    
    public function setMessage($key, $message)
    {
        $this->messages[$key] = (string) $message;
        return $this;
    }
    
    public function getMessages()
    {
        return $this->messages;
    }   
}