<?php
namespace Vision\Form\Control;

use Vision\Form\Decorator\Label;

class Submit extends ControlAbstract 
{
    protected $tag = 'input';
    
    protected $attributes = array('type' => 'submit');
    
    protected $isVoid = true; 
    
    public function init() 
    {
        $this->setAttribute('id', $this->getName());
		$this->addClass('input-' . $this->getAttribute('type'));  
        $this->setRequired(false);
    }
}