<?php
namespace Vision\Form\Control;

use Vision\Form\Decorator\Label;

class Select extends MultiOptionControlAbstract 
{
    protected $tag = 'select';

    protected $size = null;
    
    protected $multiple = false;

    public function init() 
    {
        $this->addDecorator(new Label);
        $this->setAttribute('id', $this->getName());
        $this->addClass('input-textarea');
    }
    
    public function __toString() 
    {
        $content = null;
        if ($this->view === null) {
            foreach ($this->options as $key => $value) {
                if (is_string($value)) {
                    $option = new \Vision\Html\Element('option');
                    $option->setContent($key);
                    $option->setAttribute('value', $value);
                    $content .= $option;  
                } elseif (is_array($value)) {
                
                }
            }            
            $select = new \Vision\View\Html\Element($this);
            $this->setContent($content);
            $content = $select;
        }
        foreach ($this->decorators as $decorator) {
            $decorator->setElement($this);
            $content = $decorator->render($content);
        }
        return $content;
    }
    
    public function setSize($size) 
    {
		$this->size = (int) $size;
		return $this;
	}
	
	public function getSize() 
    {
		return $this->size;
	}
	
	public function setMultiple($multiple) 
    {
		$this->multiple = (bool) $multiple;
		return $this;
	}
	
	public function getMultiple() 
    {
		return $this->multiple;
	}
}