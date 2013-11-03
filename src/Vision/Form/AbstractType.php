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
 * AbstractType
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
abstract class AbstractType extends HtmlElement
{
    /** @type array $decorators */
    protected $decorators = array();
    
    /** @type array $validators */
    protected $validators = array();
    
    /**
     * Constructor
     * 
     * @param string $name 
     */
    public function __construct($name) 
    {
        $this->setAttribute('name', trim($name));
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