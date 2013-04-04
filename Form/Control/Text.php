<?php
namespace Vision\Form\Control;

use Vision\Form\Decorator;

class Text extends ControlAbstract 
{
    protected $tag = 'input';

    protected $attributes = array('type' => 'text');

    protected $isVoid = true;    

    public function init() 
    {
        $this->addDecorator(new Decorator\Label)
             ->addDecorator(new Decorator\Li);
		$this->addClass('input-' . $this->getAttribute('type'));        
    }
}