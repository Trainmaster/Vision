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
        $content = null;

        foreach ($this->options as $key => $value) {
            $option = ElementFactory::create('option');
            $option->setContent($key);
            $option->setAttribute('value', $value);
            $content .= $option;  
        }            
        
        $this->content = $content;
        
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