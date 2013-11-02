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
 * InputInteger
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class InputInteger extends AbstractValidator 
{
    /** @type string INPUT_NOT_INTEGER */
    const INPUT_NOT_INTEGER = 'The given value could not be validated as integer.';
    
    /** @type null|int $min */
    protected $min = null;
    
    /** @type null|int $max */
    protected $max = null;
    
    /**
     * @param int $min 
     * @param int $max 
     */
    public function __construct($min = null, $max = null)
    {
        if (isset($min)) {
            $this->setMin($min);
        }
        
        if (isset($max)) {
            $this->setMax($max);
        }
    }
    
    /**
     * @api
     * 
     * @param int $min 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setMin($min)
    {
        $this->min = (int) $min;
        return $this;
    }
    
    /**
     * @api
     * 
     * @param int $max 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setMax($max)
    {
        $this->max = (int) $max;
        return $this;
    }
    
    /**
     * @api
     * 
     * @param mixed $value 
     * 
     * @return bool
     */
    public function isValid($value) 
    {
        $options = array();
        
        if (isset($this->min)) {
            $options['options']['min_range'] = $this->min;
        }
        
        if (isset($this->max)) {
            $options['options']['max_range'] = $this->max;
        }
        
        $result = filter_var($value, FILTER_VALIDATE_INT, $options);
        
        if ($result !== false) {  
            return true;
        }    
        
        $this->addError(self::INPUT_NOT_INTEGER);
        
        return false;
    }
}