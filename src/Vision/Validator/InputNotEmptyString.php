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
 * InputNotEmptyString
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class InputNotEmptyString extends AbstractValidator 
{   
    /** @type string INPUT_NOT_EMPTY_STRING */
    const INPUT_NOT_EMPTY_STRING = 'The given string is not empty.';
    
    /**
     * @api
     * 
     * @param mixed $value 
     * 
     * @return bool
     */
    public function isValid($value)
    {
        $value = filter_var($value, FILTER_UNSAFE_RAW, array('flags' => FILTER_FLAG_EMPTY_STRING_NULL));
        
        if ($value !== false || $value !== null) {
            return true;
        }
        
        $this->addError(self::INPUT_NOT_EMPTY_STRING);
        
        return false;
    }
}