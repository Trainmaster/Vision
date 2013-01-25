<?php
namespace Vision\Form\Decorator;

interface DecoratorInterface 
{		
    public function render($content);
    
	public function setElement($element);
    
	public function getElement();
    
    public function setPlacement($placement);
    
    public function getPlacement();
	
}