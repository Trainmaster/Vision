<?php
namespace Vision\Form\Decorator;

use Vision\Html\Element;

class Label extends HtmlTag 
{   
    protected $placement = self::PREPEND;   
    
    public function __construct()
    {
        $label = new Element('label');
        $this->decorator = $label;
    }
    
    public function render($content) 
    {       
        $this->decorator->setAttribute('for', $this->element->getId());
        $this->decorator->addContent($this->element->getLabel());
        
        if ($this->element->isRequired() && $this->element->getLabel()) {
            $this->decorator->addContent('<span class="required">*</span>');
        }

        return parent::render($content);
    }
}