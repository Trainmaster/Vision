<?php
namespace Vision\Form\Decorator;

use Vision\Html\ElementFactory;

class Li extends HtmlTag 
{		
    protected $placement = self::EMBED;

	public function render($content) 
    {		
        $label = ElementFactory::create('li');
        
        $this->decorator = $label;
        
        return parent::render($content);
	}
}