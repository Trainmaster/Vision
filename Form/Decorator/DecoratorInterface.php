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
 * DecoratorInterface
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
interface DecoratorInterface 
{		
    public function render($content);
    
	public function setElement($element);
    
	public function getElement();
    
    public function setPlacement($placement);
    
    public function getPlacement();
	
}