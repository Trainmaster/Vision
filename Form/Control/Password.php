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
 * Password
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class Password extends Text 
{    
    /** @type array $attributes */
    protected $attributes = array('type' => 'password');  
    
    /**
     * @return void
     */
    public function init() 
    {
        parent::init();          
    }
}