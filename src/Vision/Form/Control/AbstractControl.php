<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Form\Control;

use Vision\Form\AbstractType;
use Vision\Filter\FilterInterface;
use Vision\Validator;

/**
 * AbstractControl
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
abstract class AbstractControl extends AbstractType 
{
    /** @type array $filters */
    protected $filters = array();
    
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
    public function __construct($name) 
    {
        parent::__construct($name);    
        $this->setRequired(true);
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
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
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
        
        if ($disabled) {
            $this->setAttribute('disabled');
        } else {
            $this->removeAttribute('disabled');
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
        
        if ($readOnly) {
            $this->setAttribute('readonly');
        } else {
            $this->removeAttribute('readonly');
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
        $required = (bool) $required;
        
        if ($required) {
            $this->setAttribute('required');
        } else {
            $this->removeAttribute('required');
        }
        
        return $this;
    }
    
        
    /**
     * @api
     * 
     * @return bool
     */
    public function isRequired() 
    {
        return $this->getAttribute('required');
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
     * @param mixed $rawValue 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setRawValue($rawValue)
    {
        $this->rawValue = $rawValue;
        return $this;
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
    public function isValid() 
    {    
        $isValid = true;
        
        $value = $this->rawValue;
        
        if ($this->isRequired()) {
            $validator = new Validator\InputNotEmptyString;
            if (array_search($validator, $this->validators) === false) {           
                array_unshift($this->validators, $validator);
            }
        }
        
        foreach ($this->validators as $validator) {            
            if (!$validator->isValid($value)) {
                $key = get_class($validator);
                $this->errors[$key] = $validator->getErrors();
                $isValid = false;               
            }             
        }
        
        foreach ($this->filters as $filter) {
            $value = $filter->filter($value);
        }

        $this->setValue($value);
        
        return $isValid;
    }
}