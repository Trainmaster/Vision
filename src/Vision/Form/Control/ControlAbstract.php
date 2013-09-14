<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Form\Control;

use Vision\Html\Element as HtmlElement;
use Vision\Filter\FilterInterface;
use Vision\Validator;
use Vision\Validator\ValidatorInterface;
use Vision\Form\Decorator\DecoratorInterface;

/**
 * ControlAbstract
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
abstract class ControlAbstract extends HtmlElement 
{
    /** @type array $decorators */
    protected $decorators = array();

    /** @type array $filters */
    protected $filters = array();
    
    /** @type array $validators */
    protected $validators = array();
    
    /** @type array $errors */
    protected $errors = array();
        
    /** @type null|string $label */
    protected $label = null; 
    
    /** @type mixed $rawValue The value before filtering/validation. */
    protected $rawValue = null;
    
    /** @type mixed $value The value after filtering/validation. */
    protected $value = null;
    
    /**
     * Constructor
     * 
     * @param string $name 
     */
    final public function __construct($name) 
    {
        $this->setName($name);      
        $this->setRequired(true);
        $this->init();
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        $html = parent::__toString();
        
        foreach ($this->decorators as $decorator) {
            $html = $decorator->render($html);
        }
        
        return $html;
    }
    
    /**
     * Initializes this class with decorators, filters,
     * validators or other settings.
     *
     * @return void
     */
    abstract public function init();    

    /**
     * @api
     * 
     * @param DecoratorInterface $decorator 
     * 
     * @return $this Provides a fluent interface.
     */ 
    public function addDecorator(DecoratorInterface $decorator) 
    {
        $this->decorators[] = $decorator->setElement($this);
        return $this;
    }
    
    /**
     * @api
     * 
     * @param array $decorators 
     * 
     * @return $this Provides a fluent interface.
     */ 
    public function addDecorators(array $decorators) 
    {
        foreach ($decorators as $decorator) {
            $this->addDecorator($decorator);
        }
        return $this;
    }    

    /**
     * @api 
     * 
     * @return array
     */
    public function getDecorators() 
    {
        return $this->decorators;
    }
    
    /**
     * @api
     * 
     * @return $this Provides a fluent interface.
     */ 
    public function resetDecorators()
    {
        $this->decorators = array();
        return $this;
    }
    
    /**
     * Removes a decorator
     */
    public function removeDecorator($name) 
    {
        if (isset($this->decorators[$name])) {
            unset($this->decorators[$name]);
        }
        return $this;
    }
    
    /**
     * @api
     * 
     * @param FilterInterface $filter 
     * 
     * @return $this Provides a fluent interface.
     */ 
    public function addFilter(FilterInterface $filter) 
    {
        $this->filters[] = $filter;
        return $this;
    }
    
    /**
     * @api
     * 
     * @param array $filters 
     * 
     * @return $this Provides a fluent interface.
     */
    public function addFilters(array $filters) 
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
        return $this;
    }
    
    /**
     * @api 
     * 
     * @return array
     */
    
    public function getFilters() 
    {
        return $this->filters;
    }
    
    /**
     * @api
     * 
     * @param ValidatorInterface $validator 
     * 
     * @return $this Provides a fluent interface.
     */
    public function addValidator(ValidatorInterface $validator) 
    {
        $this->validators[] = $validator;
        return $this;
    }
    
    /**
     * @api
     * 
     * @param array $validators 
     * 
     * @return $this Provides a fluent interface.
     */
    
    public function addValidators(array $validators) 
    {
        foreach ($validators as $validator) {
            $this->addValidator($validator);
        }
        return $this;
    }
    
    /**
     * @api
     * 
     * @return array
     */
    public function getValidators() 
    {    
        return $this->validators;
    }
    
    /**
     * @api
     * 
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * @api
     * 
     * @param string $name 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setName($name) 
    {
        $this->setAttribute('name', (string) $name);
        return $this;

    }
    
    /**
     * @api
     * 
     * @return string
     */
    public function getName() 
    {
        return $this->getAttribute('name');
    }

    /**
     * @api
     * 
     * @param bool $disabled 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setDisabled($disabled) 
    {
        $disabled = (bool) $disabled;
        
        if ($disabled === true) {
            $this->setAttribute('disabled', 'disabled');
        }
        
        return $this;
    }
    
    /**
     * @api
     * 
     * @param bool $readOnly 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setReadOnly($readOnly) 
    {
        $readOnly = (bool) $readOnly;
        
        if ($readOnly === true) {
            $this->setAttribute('readonly', 'readonly');
        }
        
        return $this;
    }        
    
    /**
     * @api
     * 
     * @param bool $value 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setRequired($required) 
    {
        $this->required = (bool) $required;
        $attribute = $this->getAttribute('required');
        
        if ($required) {
            $this->setAttribute('required');
        } elseif ($attribute === null) {
            $this->removeAttribute('required');
        }
        
        return $this;
    }
    
    /**
     * @api
     * 
     * @param string $value 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setPlaceholder($placeholder)
    {
        $this->setAttribute('placeholder', $placeholder);
        return $this;
    }
    
    /**
     * @api
     * 
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }
    
    /**
     * @api
     * 
     * @return bool
     */
    public function isRequired() 
    {
        return $this->required;
    }
    
    /**
     * @api
     * 
     * @param mixed $value 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setValue($value) 
    {   
        $this->setAttribute('value', $value);
        $this->value = $value;
        return $this;
    }
    
    /**
     * @api
     * 
     * @return mixed
     */
    public function getValue() 
    {
        return $this->value;
    }   
        
    /**
     * @api
     * 
     * @return mixed
     */
    public function getRawValue() 
    {
        return $this->rawValue;
    }
    
    /**
     * @api
     * 
     * @param string $label 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setLabel($label) 
    {
        $this->label = (string) $label;
        return $this;
    }
    
    /**
     * @api
     * 
     * @return string
     */
    public function getLabel() 
    {
        return $this->label;
    }
    
    /**
     * @api
     * 
     * @param mixed $value 
     * 
     * @return bool
     */
    public function isValid($value) 
    {    
        $isValid = true;
        
        $this->rawValue = $value;
        
        if ($this->isRequired()) {              
            array_unshift($this->validators, new Validator\InputNotEmptyString);
        }
        
        foreach ($this->filters as $filter) {
            $value = $filter->filter($value);
        }
        
        foreach ($this->validators as $validator) {            
            if ($validator->isValid($value) === false) {
                $key = get_class($validator);
                $this->errors[$key] = $validator->getErrors();
                $isValid = false;               
            }             
        }

        if ($isValid === true) {
            $this->setValue($value);
        }
        
        return $isValid;
    }
}