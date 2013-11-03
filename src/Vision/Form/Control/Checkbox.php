<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Form\Control;

use Vision\Html\Element as HtmlElement;
use Vision\Html\ElementFactory;
use Vision\Form\Decorator;
use Vision\Validator;

/**
 * Checkbox
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class Checkbox extends MultiOptionAbstractControl 
{
    /** @type string $input */
    protected $tag = 'input';
    
    /** @type array $attributes */
    protected $attributes = array('type' => 'checkbox');
    
    /** @type bool $isVoid */
    protected $isVoid = true; 
    
    /**
     * @return void
     */
    public function init() 
    {
        $label = new Decorator\Label;
        $label->setPlacement('APPEND');
        $label->getDecorator()->addClass('label-checkbox');
        
        $li = new Decorator\Li;
        
        $this->addDecorator($label)
             ->addDecorator($li);
        $this->setRequired(false);
    }
    
    /**
     * @return string
     */
    public function __toString() 
    {   
        $html = '';
        
        foreach ($this->options as $option => $label) {
            $this->removeAttribute('checked');
            $this->setLabel($label);
            $this->setAttribute('value', $option);            
            
            if ($this->checkForPreSelection($option)) {
                $this->setAttribute('checked', 'checked');
            }         

            $html .= parent::__toString();
        }
        
        return $html;
    }
    
    /**
     * @return array
     */
    public function getValidators()
    {
        $options = $this->getOptions();
        $count = count($options);
        
        if ($count > 1) {
            $this->addValidator(new Validator\InArray(array('haystack' => $options)));
        }
        
        return $this->validators;
    }
}