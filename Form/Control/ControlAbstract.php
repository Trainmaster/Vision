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
    protected $decorators = array();

    protected $filters = array();
    
    protected $validators = array();
    
    protected $errors = array();
        
    protected $label = null; 
        
    protected $value = null;
    
    protected $rawValue = null;
    
    final public function __construct($name) 
    {
        $this->setName($name);      
        $this->setRequired(true);
        $this->init();
    }
    
    abstract public function init();

    public function __toString()
    {
        $html = parent::__toString();
        
        foreach ($this->decorators as $decorator) {
            $html = $decorator->render($html);
        }
        
        return $html;
    }

    /**
     * Add a decorator
     */
    public function addDecorator(DecoratorInterface $decorator) 
    {
        $this->decorators[] = $decorator->setElement($this);
        return $this;
    }
    
    /**
     * Add decorators
     */
    public function addDecorators(array $decorators) 
    {
        foreach ($decorators as $decorator) {
            $this->addDecorator($decorator);
        }
        return $this;
    }
    
    /**
     * Gets all decorators
     */
    public function getDecorators() 
    {
        return $this->decorators;
    }
    
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
     * Add filter
     */ 
    public function addFilter(FilterInterface $filter) 
    {
        $this->filters[] = $filter;
        return $this;
    }
    
    /**
     * Add multiple filters at once.
     */ 
    public function addFilters(array $filters) 
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
        return $this;
    }
    
    /**
     * Get all filters.
     */
    public function getFilters() 
    {
        return $this->filters;
    }
    
    /**
     * Add validator.
     */ 
    public function addValidator(ValidatorInterface $validator) 
    {
        $this->validators[] = $validator;
        return $this;
    }
    
    /**
     * Add multiple validators at once.
     */ 
    public function addValidators(array $validators) 
    {
        foreach ($validators as $validator) {
            $this->addValidator($validator);
        }
        return $this;
    }
    
    /**
     * Get all validators.
     */
    public function getValidators () 
    {    
        return $this->validators;
    }
    
    /**
     * @param array $errors 
     * 
     * @return ControlAbstract Provides a fluent interface.
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * Set name attribute.
     */
    public function setName($name) 
    {
        $this->setAttribute('name', (string) $name);
        return $this;

    }
    
    /**
     * Gets name attribute.
     */
    public function getName() 
    {
        return $this->getAttribute('name');
    }

    public function setDisabled($disabled) 
    {
        $disabled = (bool) $disabled;
        if ($disabled === true) {
            $this->setAttribute('disabled', 'disabled');
        }
        return $this;
    }
    
    public function setReadOnly($readOnly) 
    {
        $readOnly = (bool) $readOnly;
        if ($readOnly === true) {
            $this->setAttribute('readonly', 'readonly');
        }
        return $this;
    }        
    
    /**
     * Sets required flag
     */
    public function setRequired($required) 
    {
        $this->required = (bool) $required;
        $attribute = $this->getAttribute('required');
        if ($required === true) {
            $this->setAttribute('required');
        } elseif ($attribute === null) {
            $this->removeAttribute('required');
        }
        return $this;
    }
    
    public function setPlaceholder($placeholder)
    {
        $this->setAttribute('placeholder', $placeholder);
        return $this;
    }
    
    public function getPlaceholder()
    {
        return $this->placeholder;
    }
    
    /**
     * Gets required flag
     */
    public function isRequired() 
    {
        return $this->required;
    }
    
    /**
     * Sets value.
     */
    public function setValue($value) 
    {   
        $this->setAttribute('value', $value);
        $this->value = $value;
        return $this;
    }
    
    /**
     * Gets value.
     */
    public function getValue() 
    {
        return $this->value;
    }   
        
    /**
     * Get raw value
     */
    public function getRawValue() 
    {
        return $this->rawValue;
    }

    /**
     * Set label
     */
    public function setLabel($label) 
    {
        $this->label = (string) $label;
        return $this;
    }
    
    /**
     * Get label
     */
    public function getLabel() 
    {
        return $this->label;
    }
    
    /**
     * Check if value is valid
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
        
        $errors = array();
        
        foreach ($this->validators as $validator) {            
            if ($validator->isValid($value) === false) {
                $key = get_class($validator);
                $errors[$key] = $validator->getErrors();
                $isValid = false;               
            }             
        }
        
        if (!empty($errors)) {
            $this->setErrors($errors);
        }
        
        if ($isValid === true) {
            $this->setValue($value);
        }
        
        return $isValid;
    }
}