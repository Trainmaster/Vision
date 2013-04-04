<?php 
namespace Vision\Form;

use Vision\Http\RequestInterface;
use Vision\Html\Element as HtmlElement;
use Vision\View\Html\ElementAbstract as HtmlElementViewAbstract;
use RecursiveIteratorIterator;

class Form extends AbstractCompositeType 
{    
    protected $tag = 'form';
    
    protected $attributes = array(
                                'action' => '',
                                'enctype' => 'multipart/form-data',
                                'method' => 'post'
                            );
                            
    protected $data = null;
    
    protected $formElementsIterator = null;
    
    public function init() {}
    
    public function setAction($action)
    {
        $this->setAttribute('action', $action);
        return $this;
    }           
    
    public function getFormElementsIterator()
    {
        if ($this->formElementsIterator === null) {
            $formElementsIterator = new Iterator\FormElementsIterator($this->elements);             
            $this->formElementsIterator = new RecursiveIteratorIterator($formElementsIterator, RecursiveIteratorIterator::CHILD_FIRST);
        }
        
        return $this->formElementsIterator;
    }
    
    public function getElement($name) 
    {
        $iterator = $this->getFormElementsIterator();
        
        foreach ($iterator as $key => $element) {       
            if ($element->getName() === $name) {
                return $element;
            }            
        } 
        
        return null;
    }
    
    public function getElementByName($name)
    {
        return $this->getElement($name);
    }
    
    /**
    * Extract value by html array notation.
    *
    * @param string $name
    *
    * @return string|string
    */  
	public function extractValue($name) 
    {
        if (strpos($name, '[]') !== false) {
            $name = str_replace('[]', '', $name);
        }
		$parts = explode('[', $name);
		$value = $this->data;
		foreach ($parts as $part) {
			$part = trim($part, ']');
			if (isset($value[$part])) {
				$value = $value[$part];
			} else {
				return null;
			}
		} 
		return $value;
	}
     
    public function bindData($data)
    {
        $this->data = $data;
        return $this;
    }
    
    public function getData()
    {
        return $this->data;
    }
    
    public function isSent()
    {
        if (isset($this->data[$this->name])) {
            return true;
        }
        return false;
    }
    
	public function isValid() 
    {         
        $isValid = true;    
        
        $iterator = $this->getFormElementsIterator();
        
        foreach ($iterator as $key => $element) {
            if ($element instanceof Control\ControlAbstract) {
                $value = $this->extractValue($element->getName());
                if ($element->isValid($value) === false) {
                    $isValid = false;
                }
            }
        }  

        return $isValid;
	}
}