<?php
namespace Vision\Form\Control;

class Email extends Text 
{
    protected $tag = 'input'; 
    
    protected $attributes = array('type' => 'text');
    
    protected $isVoidElement = true;          
    
    public function init() 
    {
        parent::init();
        $this->addValidator(new \Vision\Validator\Email);            
    }
}