<?php
namespace Vision\Form\Decorator;

use Vision\Html\ElementFactory;

class Label extends HtmlTag 
{		
	public function render($content) 
    {		
        $label = ElementFactory::create('label');
        $label->setAttribute('for', $this->element->getId());
        $label->setContent($this->element->getLabel());
        
        if ($this->element->isRequired()) {
            $label->setContent($label->getContent() . '<span class="required">*</span>');
        }
        
        $this->decorator = $label;
        
        return parent::render($content);
	}
}