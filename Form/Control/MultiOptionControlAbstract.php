<?php
namespace Vision\Form\Control;

abstract class MultiOptionControlAbstract extends ControlAbstract 
{
    protected $options = array();
    
    public function setOptions(array $options) 
    {
        $this->options = $options;
        return $this;
    }
    
    public function getOptions() 
    {
        return $this->options;
    }
    
    public function checkForPreSelection($val)
    {
        $value = $this->getValue();
        
        if (is_array($value)) {
            if (in_array($val, $value)) {
                return true;
            }
        } elseif (is_string($value) || is_bool($value) || is_int($value)) {                
            if ($val == $value) {
                return true;
            }
        }
        
        return false;
    }
}