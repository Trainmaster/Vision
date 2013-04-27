<?php
namespace Vision\Form\Decorator;

use Vision\Html\ElementFactory;

class Label extends HtmlTag 
{   
    protected $placement = self::PREPEND;   
    
    public function __construct()
    {
        $label = ElementFactory::create('label');
        $this->decorator = $label;
    }
    
    public function render($content) 
    {       
        $this->decorator->setAttribute('for', $this->element->getId());
        $this->decorator->setContent($this->element->getLabel());
        
        if ($this->element->isRequired()) {
            $this->decorator->setContent($this->decorator->getContent() . '<span class="required">*</span>');
        }

        return parent::render($content);
    }
}