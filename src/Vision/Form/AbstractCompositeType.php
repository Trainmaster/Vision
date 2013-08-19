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
    /** @type string|null $name */
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
     * 
     * @return void
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
     * @param mixed $element 
     * 
     * @return AbstractCompositeType Provides a fluent interface.
     */
    public function addElement($element) 
    {
        $this->elements[] = $element;
        return $this;
    }
    
    /**
     * @param array $elements 
     * 
     * @return AbstractCompositeType Provides a fluent interface.
     */
    public function addElements(array $elements) 
    {
        foreach ($elements as $element) {
            $this->addElement($element);
        }
        return $this;
    }
    
    /**
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
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }   

    /**
     * @return AbstractCompositeType Provides a fluent interface.
     */
    public function addDecorator(DecoratorInterface $decorator) 
    {
        $this->decorators[] = $decorator;
        return $this;
    }
    
    /**
     * @return AbstractCompositeType Provides a fluent interface.
     */
    public function addDecorators(array $decorators) 
    {
        foreach ($decorators as $decorator) {
            $this->addDecorator($decorator);
        }
        return $this;
    }
    
    /**
     * @return array
     */
    public function getDecorators() 
    {
        return $this->decorators;
    }
    
    /** 
     * @return AbstractCompositeType Provides a fluent interface.
     */
    public function resetDecorators()
    {
        $this->decorators = array();
        return $this;
    }    
    
    /**
     * @return AbstractCompositeType Provides a fluent interface.
     */
    public function addValidator(ValidatorInterface $validator) 
    {
        $this->validators[] = $validator;
        return $this;
    }
    
    /**
     * @return AbstractCompositeType Provides a fluent interface.
     */
    public function addValidators(array $validators) 
    {
        foreach ($validators as $validator) {
            $this->addValidator($validator);
        }
        return $this;
    }
    
    /**
     * @return array
     */
    public function getValidators() 
    {
        return $this->validators;
    }
    
    /** 
     * @return AbstractCompositeType Provides a fluent interface.
     */
    public function resetValidators()
    {
        $this->validators = array();
        return $this;
    }
}