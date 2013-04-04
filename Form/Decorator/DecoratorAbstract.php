<?php
namespace Vision\Form\Decorator;

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