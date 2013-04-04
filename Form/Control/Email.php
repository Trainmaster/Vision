<?php
namespace Vision\Form\Control;

use Vision\Validator;

class Email extends Text 
{    
    protected $attributes = array('type' => 'email');   
    
    public function init() 
    {
        parent::init();
        $this->addValidator(new Validator\Email);            
    }
}