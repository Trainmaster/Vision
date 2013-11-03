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
use Vision\Html\Element;

/**
 * Select
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class Select extends MultiOptionAbstractControl 
{
    /**
     * Constructor
     * 
     * @param string $name 
     */
    public function __construct($name)
    {
        parent::__construct($name);
        
        $this->setTag('select')
             ->addDecorator(new Decorator\Label)
             ->addDecorator(new Decorator\Li)
             ->addClass('input-select'));            
    }  
    
    public function __toString() 
    {
        foreach ($this->options as $value => $content) {
            $option = new Element('option');
            $option->setAttribute('value', $value);
            $option->addContent($content);
            
            if ($this->checkForPreSelection($value)) {
                $option->setAttribute('selected', 'selected');
            }
            
            $this->addContent($option);
        }
        
        return parent::__toString();
    }
    
    public function setSize($size) 
    {
        $this->setAttribute('size', (int) $size);
        return $this;
    }
    
    public function getSize() 
    {
        return $this->getAttribute('size');
    }
    
    public function setMultiple($multiple) 
    {
        $this->setAttribute('multiple', null);
        return $this;
    }
    
    public function getMultiple() 
    {
        return $this->getAttribute('multiple');
    }
}