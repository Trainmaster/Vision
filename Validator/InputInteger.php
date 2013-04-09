<?php
namespace Vision\Validator;

class InputInteger extends ValidatorAbstract 
{
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
        
        $this->setMessage('Integer', 'Value is not an integer');
        
        return false;
    }
}