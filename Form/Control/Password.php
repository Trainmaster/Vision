<?php
namespace Vision\Form\Control;

class Password extends Text 
{    
    protected $attributes = array('type' => 'password');  
    
    public function init() 
    {
        parent::init();          
    }
}