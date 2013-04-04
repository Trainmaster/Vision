<?php
namespace Vision\Form\Control;

class Number extends Text 
{    
    protected $attributes = array('type' => 'number');  
    
    public function init() 
    {
        parent::init(); 
    }
    
    public function setMin($min)
    {
        $this->setAttribute('min', (int) $min);
        return $this;
    }
    
    public function setMax($max)
    {
        $this->setAttribute('max', (int) $max);
        return $this;
    }   
}