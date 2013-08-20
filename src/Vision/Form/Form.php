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
use InvalidArgumentException;

/**
 * Form
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class Form extends AbstractCompositeType 
{        
    /** @type array $attributes */
    protected $attributes = array(
        'action' => '',
        'enctype' => 'multipart/form-data',
        'method' => 'post'
    );
           
    /** @type array */
    protected $data = array();
    
    /** @type array $errors */
    protected $errors = array();
    
    /** @type array $values */
    protected $values = array();
    
    /** @type string $tag */
    protected $tag = 'form';
    
    /** @type int $tabindex */
    protected $tabindex = 0;
    
    /** @type RecursiveIteratorIterator|null $formElementsIterator */
    protected $formElementsIterator = null;
    
    /**
     * @api
     * 
     * @return integer
     */
    public function increment()
    {
        return ++$this->tabindex;
    }
    
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
     * @api
     *
     * @param mixed $name 
     * 
     * @return mixed
     */
    public function getElement($mixed) 
    {
        if (is_string($mixed)) {
            $name = trim($mixed);
        } elseif ($mixed instanceof Control\ControlAbstract) {
            $name = $mixed->getName();
        } else {
            throw new InvalidArgumentException('');
        }
        
        $iterator = $this->getIterator();
        
        foreach ($iterator as $element) {       
            if ($element->getName() === $name) {
                return $element;
            }            
        } 
        
        return null;
    }
    
    /**
     * @api
     *
     * @param string $name 
     * 
     * @return Form\ControlAbstract | null
     */
    public function getElementByName($name)
    {
        return $this->getElement($name);
    }
    
    /**
     * @api
     *
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
     * @api
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
     * @api
     *
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
                $name = $element->getName();
                $value = $this->getValueByName($name);
                
                if (!$element->isRequired() && empty($value)) {
                    continue;
                }

                if (!$element->isValid($value)) {
                    $this->errors[$name] = $element->getErrors();
                    $isValid = false;
                }
                
                $this->values[$name] = $element->getValue();
            }
        }  
        
        foreach ($this->validators as $validator) {
            if (!$validator->isValid($this)) {
                $key = get_class($validator);
                $this->errors[$this->name][$key] = $validator->getErrors();
                $isValid = false;
            }
        }

        return $isValid;
    }
}