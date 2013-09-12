<?php
namespace Vision\Validator;

class InputInteger extends AbstractValidator 
{
    const NO_INTEGER = 'The given value could not be validated as integer.';
    
    protected $min = null;
    
    protected $max = null;
    
    public function setMin($min)
    {
        $this->min = (int) $min;
        return $this;
    }
    
    public function setMax($max)
    {
        $this->max = (int) $max;
        return $this;
    }
    
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
        
        if ($result) {  
            return true;
        }    
        
        $this->addError(self::NO_INTEGER);
        
        return false;
    }
}