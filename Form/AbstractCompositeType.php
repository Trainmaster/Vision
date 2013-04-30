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

/**
 * AbstractCompositeType
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
abstract class AbstractCompositeType extends HtmlElement
{
    protected $name = null;
    
    protected $elements = array();    
    
    protected $decorators = array();
    
    final public function __construct($name) 
    {
        $this->name = trim($name);
        $this->init();
    }     
    
    abstract public function init();
    
    public function getContent() 
    {
        $content = '';
        
        foreach ($this->elements as $element) {
            $content .= (string) $element;
        }
        
        foreach ($this->decorators as $decorator) {
            $decorator->setElement($this);
            $content = $decorator->render($content);
        }      
        
        return $content;
    }
    
    public function addElement($element) 
    {
        $this->elements[] = $element;
        return $this;
    }
    
    public function addElements(array $elements) 
    {
		foreach ($elements as $element) {
			$this->addElement($element);
		}
        return $this;
	}
    
    public function getElement($name) 
    {
        if (isset($this->elements[$name])) {
            return $this->elements[$name];
        }
		return null;
	}
    
    public function getElements()
    {
        return $this->elements;
    }
    
    public function getName()
    {
        return $this->name;
    }   

    /**
     * Add a decorator
     */
	public function addDecorator(Decorator\DecoratorInterface $decorator) 
    {
        $this->decorators[] = $decorator;
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
     * Get all decorators
     */
	public function getDecorators() 
    {
		return $this->decorators;
	}
    
    /**
     * Reset decorators
     */
    public function resetDecorators()
    {
        $this->decorators = array();
        return $this;
    }
}