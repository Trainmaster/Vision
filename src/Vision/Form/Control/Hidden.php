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
 * Hidden
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class Hidden extends Text 
{
    /** @type array $attributes */
    protected $attributes = array('type' => 'hidden');

    /**
     * @return void
     */
    public function init() 
    {
        $this->setAttribute('id', $this->getName());
        $this->setAttribute('readonly', 'readonly');
        $this->addClass('input-' . $this->getAttribute('type'));        
    }
}