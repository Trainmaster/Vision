<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Form;

use Vision\Html\Element as HtmlElement;

use Vision\Form\Decorator\DecoratorInterface;
use Vision\Validator\ValidatorInterface;

/**
 * AbstractCompositeType
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
abstract class AbstractCompositeType extends HtmlElement
{
    /** @type null|string $name */
    protected $name = null;
    
    /** @type array $elements */
    protected $elements = array();    
    
    /** @type array $decorators */
    protected $decorators = array();
    
    /** @type array $validators */
    protected $validators = array();
    
    /**
     * Constructor
     * 
     * @param string $name 
     */
    final public function __construct($name) 
    {
        $this->name = trim($name);
        $this->init();
    }     
    
    /**
     * @return void
     */
    abstract public function init();
    
    /**
     * @api
     *
     * @return string
     */
    public function getContents() 
    {
        $content = '';
        
        foreach ($this->elements as $element) {
            $content .= $element;
        }
        
        foreach ($this->decorators as $decorator) {
            $decorator->setElement($this);
            $content = $decorator->render($content);
        }      
        
        return $content;
    }
    
    /**
     * @api
     *
     * @param mixed $element 
     * 
     * @return $this Provides a fluent interface.
     */
    public function addElement($element) 
    {
        $this->elements[] = $element;
        return $this;
    }
    
    /**
     * @api
     *
     * @param array $elements 
     * 
     * @return $this Provides a fluent interface.
     */
    public function addElements(array $elements) 
    {
        foreach ($elements as $element) {
            $this->addElement($element);
        }
        return $this;
    }
    
    /**
     * @api
     *
     * @param string $name 
     * 
     * @return mixed
     */
    public function getElement($name) 
    {
        if (isset($this->elements[$name])) {
            return $this->elements[$name];
        }
        return null;
    }
    
    /**
     * @api
     *
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }
    
    /**
     * @api
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }   

    /**
     * @api
     *
     * @param DecoratorInterface $decorator
     *
     * @return $this Provides a fluent interface.
     */
    public function addDecorator(DecoratorInterface $decorator) 
    {
        $this->decorators[] = $decorator;
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
     * @return $this Provides a fluent interface.
     */
    public function resetValidators()
    {
        $this->validators = array();
        return $this;
    }
}