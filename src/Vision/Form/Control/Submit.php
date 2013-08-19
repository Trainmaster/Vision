<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Form\Control;

use Vision\Form\Decorator\Label;

/**
 * Submit
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class Submit extends ControlAbstract 
{
    protected $tag = 'input';
    
    protected $attributes = array('type' => 'submit');
    
    protected $isVoid = true; 
    
    public function init() 
    {
        $this->setAttribute('id', $this->getName());
		$this->addClass('input-' . $this->getAttribute('type'));  
        $this->setRequired(false);
    }
}