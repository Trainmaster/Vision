<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Form\Control;

/**
 * Number
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class Number extends Text 
{
    /** @type array $attributes */
    protected $attributes = array('type' => 'number');
    
    /**
     * @param int $min 
     * 
     * @return Number Provides a fluent interface.
     */
    public function setMin($min)
    {
        $this->setAttribute('min', (int) $min);
        return $this;
    }
    
    /**
     * @param int $max 
     * 
     * @return Number Provides a fluent interface.
     */
    public function setMax($max)
    {
        $this->setAttribute('max', (int) $max);
        return $this;
    }   
}