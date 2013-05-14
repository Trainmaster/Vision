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
 * ValidatorChain
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 *
 */
class ValidatorChain
{
    protected $validators = array();
    
    public function add(ValidatorInterface $validator)
    {
        $this->validators[] = $validator;
        return $this;
    }
    
    public function isValid($value)
    {
        $isValid = true;
        
        foreach ($this->validators as $validator) {
            $isValid = $validator->isValid($value);
            if ($isValid === false) {
                break;
            }
        }
        
        return $isValid;
    }
}