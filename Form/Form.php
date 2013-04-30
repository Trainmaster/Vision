<?php 
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Form;

use Vision\Http\RequestInterface;
use Vision\Html\Element as HtmlElement;
use Vision\View\Html\ElementAbstract as HtmlElementViewAbstract;
use RecursiveIteratorIterator;

/**
 * Form
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
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
    
    public function getValue($name)
    {
        $element = $this->getElementByName($name);
        
        if ($element) {
            return $element->getValue();
        }
        
        return $element;
    }
    
    /**
     * Retrieve array value by html array notation
     * 
     * Example: $this->getValueByName(foo[bar][baz]) returns
     *          the value of $this->data[$foo][$bar][$baz] or NULL.
     * 
     * @param string $name 
     * 
     * @return mixed|null
     */
    public function getValueByName($name)
    {
        if (strpos($name, '[]') !== false) {
            $name = str_replace('[]', '', $name);
        }
        
        $parts = explode('[', $name);
        $value = $this->data;
        
        foreach ($parts as $part) {
            $part = rtrim($part, ']');
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
        
        foreach ($iterator as $element) {
            if ($element instanceof Control\ControlAbstract) {
                $value = $this->getValueByName($element->getName());
                
                if ($element->isRequired() === false && empty($value)) {
                    continue;
                }

                if ($element->isValid($value) === false) {
                    $isValid = false;
                }
            }
        }  

        return $isValid;
    }
}