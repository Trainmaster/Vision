<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Form\Control;

use Vision\Form\Decorator;

/**
 * File
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class File extends ControlAbstract 
{
    protected $tag = 'input';

    protected $attributes = array('type' => 'file');

    protected $isVoid = true;    

    public function init() 
    {
        $this->addDecorator(new Decorator\Label)
             ->addDecorator(new Decorator\Li);
		$this->addClass('input-' . $this->getAttribute('type'));        
    }
}