<?php
namespace Vision\Form;

use Vision\Html\Element as HtmlElement;

abstract class AbstractCompositeType extends HtmlElement
{
    protected $name = null;
    
    protected $elements = array();    
    
    public function __construct($name) 
    {
        $this->name = trim($name);
    }      
    
    public function addElement($element) 
    {
        $this->elements[] = $element;
        return $this;
    }
    
    public function addElements(array $elements) 
    {
		foreach ($elements as $element) {
			$this->addElement($element);
		}
        return $this;
	}
    
    public function getElement($name) 
    {
        if (isset($this->elements[$name])) {
            return $this->elements[$name];
        }
		return null;
	}
    
    public function getElements()
    {
        return $this->elements;
    }
    
    public function getName()
    {
        return $this->name;
    }
}