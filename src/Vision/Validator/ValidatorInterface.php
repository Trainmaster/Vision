<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Validator;

/**
 * ValidatorInterface
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
interface ValidatorInterface 
{
    public function isValid($value);
    
    public function addError($error);
    
    public function getErrors();  
}