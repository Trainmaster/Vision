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
 * Text
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class Text extends AbstractControl 
{
    /** @type string $tag */
    protected $tag = 'input';

    /** @type array $attributes */
    protected $attributes = array('type' => 'text');

    /** @type bool $isVoid */
    protected $isVoid = true;    

    /**
     * @return void
     */
    public function init() 
    {
        $this->addDecorator(new Decorator\Label)
             ->addDecorator(new Decorator\Li);
		$this->addClass('input-' . $this->getAttribute('type'));        
    }
}