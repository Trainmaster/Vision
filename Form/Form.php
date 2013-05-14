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
    /** @type string $tag */
    protected $tag = 'form';
    
    /** @type array $attributes */
    protected $attributes = array(
        'action' => '',
        'enctype' => 'multipart/form-data',
        'method' => 'post'
    );
           
    /** @type null|array */
    protected $data = null;
    
    /** @type null|RecursiveIteratorIterator $formElementsIterator */
    protected $formElementsIterator = null;
    
    /** @type array $errors */
    protected $errors = array();
    
    /** @type array $values */
    protected $values = array();
    
    /**
     * @return void
     */    
    public function init() {}
    
    /**
     * @param string $action 
     * 
     * @return Form Provides a fluent interface.
     */
    public function setAction($action)
    {
        $this->setAttribute('action', $action);
        return $this;
    }           
    
    /**
     * @return RecursiveIteratorIterator
     */
    public function getIterator()
    {
        if ($this->formElementsIterator === null) {
            $formElementsIterator = new Iterator\FormElementsIterator($this->elements);             
            $this->formElementsIterator = new RecursiveIteratorIterator($formElementsIterator, RecursiveIteratorIterator::CHILD_FIRST);
        }
        
        return $this->formElementsIterator;
    }
    
    /**
     * @param string $name 
     * 
     * @return null|Form\ControlAbstract
     */
    public function getElement($name) 
    {
        $iterator = $this->getIterator();
        
        foreach ($iterator as $key => $element) {       
            if ($element->getName() === $name) {
                return $element;
            }            
        } 
        
        return null;
    }
    
    /**
     * @param string $name 
     * 
     * @return Form\ControlAbstract|null
     */
    public function getElementByName($name)
    {
        return $this->getElement($name);
    }
    
    /**
     * @param string $name 
     * 
     * @return mixed|bool
     */
    public function getValue($name)
    {
        $element = $this->getElementByName($name);
        
        if ($element) {
            return $element->getValue();
        }
        
        return false;
    }
    
    /**
     * 
     * 
     * @param array $data 
     * 
     * @return Form Provides a fluent interface.
     */
    public function setValues(array $data)
    {
        $iterator = $this->getIterator();
        
        foreach ($iterator as $element) {
            $name = $element->getName();
            if (isset($data[$name])) {
                $element->setValue($data[$name]);
            }
        }
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }
    
    /**
     * Retrieve array value by html array notation
     * 
     * Example: $this->getValueByName(foo[bar][baz]) returns
     *          the value of $this->data[$foo][$bar][$baz] or NULL.
     * 
     * @param string $name 
     * 
     * @return null|mixed
     */
    protected function getValueByName($name)
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
     
    /** 
     * @param array $data 
     * 
     * @return Form Provides a fluent interface.
     */
    public function bindData(array $data)
    {
        $this->data = $data;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * @return bool
     */
    public function isSent()
    {
        if (isset($this->data[$this->name])) {
            return true;
        }
        return false;
    }
    
    /**
     * @return bool
     */
    public function isValid() 
    {         
        $isValid = true;    
        
        $iterator = $this->getIterator();
        
        foreach ($iterator as $element) {
            if ($element instanceof Control\ControlAbstract) {
                $value = $this->getValueByName($element->getName());
                
                if ($element->isRequired() === false && empty($value)) {
                    continue;
                }

                if ($element->isValid($value) === false) {
                    $this->errors[$element->getName()] = $element->getErrors();
                    $isValid = false;
                }
                
                $this->values[$element->getName()] = $element->getValue();
            }
        }  

        return $isValid;
    }
}