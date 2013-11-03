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
 * Submit
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class Submit extends AbstractControl 
{
    /**
     * Constructor
     * 
     * @param string $name 
     */
    public function __construct($name)
    {
        parent::__construct($name);
        
        $this->setTag('input')
             ->setAttribute('type', 'submit')
             ->setAttribute('id', $this->getName())
             ->addClass('input-' . $this->getAttribute('type'))
             ->setRequired(false);            
    }    
}