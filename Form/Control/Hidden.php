<?php
namespace Vision\Form\Control;

use Vision\Form\Decorator;

class Hidden extends Text 
{
    protected $attributes = array('type' => 'hidden');

    public function init() 
    {
        $this->setAttribute('id', $this->getName());
        $this->setAttribute('readonly', 'readonly');
		$this->addClass('input-' . $this->getAttribute('type'));        
    }
}