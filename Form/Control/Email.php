<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Form\Control;

use Vision\Validator;

/**
 * Email
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class Email extends Text 
{    
    /** @type array $attributes */
    protected $attributes = array('type' => 'email');   
    
    /**
     * @return void
     */
    public function init() 
    {
        parent::init();
        $this->addValidator(new Validator\Email);            
    }
}