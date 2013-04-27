<?php
namespace Vision\Form\Control;

use Vision\Form\Decorator;
use Vision\Html\ElementFactory;

class Select extends MultiOptionControlAbstract 
{
    protected $tag = 'select';

    public function init() 
    {
        $this->addDecorator(new Decorator\Label)
             ->addDecorator(new Decorator\Li);
        $this->addClass('input-select');    
    }
    
    public function __toString() 
    {
        $html = '';
        
        $option = ElementFactory::create('option');
                
        foreach ($this->options as $value => $content) {
            $option->removeAttribute('selected');
            $option->setAttribute('value', $value);
            $option->setContent($content);
            if ($this->checkForPreSelection($value)) {
                $option->setAttribute('selected', 'selected');
            }
            $html .= $option;  
        }            
        
        $this->content = $html;
        
        return parent::__toString();
    }
    
    public function setSize($size) 
    {
        $this->setAttribute('size', (int) $size);
        return $this;
    }
    
    public function getSize() 
    {
        return $this->getAttribute('size');
    }
    
    public function setMultiple($multiple) 
    {
        $this->setAttribute('multiple', null);
        return $this;
    }
    
    public function getMultiple() 
    {
        return $this->getAttribute('multiple');
    }
}