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
 * MultiOptionAbstractControl
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
abstract class MultiOptionAbstractControl extends AbstractControl 
{
    /** @type array $options */
    protected $options = array();
    
    /** 
     * @param array $options 
     * 
     * @return MultiOptionAbstractControl Provides a fluent interface.
     */
    public function setOptions(array $options) 
    {
        $this->options = $options;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getOptions() 
    {
        return $this->options;
    }
    
    /**
     * @param mixed $val 
     * 
     * @return bool
     */
    public function checkForPreSelection($val)
    {
        $value = $this->getValue();
        
        if (is_array($value)) {
            if (in_array($val, $value)) {
                return true;
            }
        } elseif (is_string($value) || is_bool($value) || is_int($value)) {                
            if ($val == $value) {
                return true;
            }
        }
        
        return false;
    }
}