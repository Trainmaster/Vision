<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Form\Decorator;

/**
 * DecoratorAbstract
 *
 * @author Frank Liepert
 */ 
abstract class DecoratorAbstract implements DecoratorInterface 
{   
    const APPEND = 'APPEND';
    
    const PREPEND = 'PREPEND';  
    
    const WRAP = 'WRAP';    
    
    protected $element = null;
        
    protected $placement = self::PREPEND;   
    
    public function render($content) {}
    
    public function setElement($element) 
    {
        $this->element = $element;
        return $this;
    }
    
    public function getElement() 
    {
        return $this->element;
    }
    
    public function setPlacement($placement) 
    {
        $this->placement = strtoupper($placement);
        return $this;
    }
    
    public function getPlacement() 
    {
        return $this->placement;
    }
}