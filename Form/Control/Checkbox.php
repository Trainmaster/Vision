<?php
namespace Vision\Form\Control;

use Vision\Html\Element as HtmlElement;
use Vision\Html\ElementFactory;
use Vision\Form\Decorator;
use Vision\Validator;

class Checkbox extends MultiOptionControlAbstract 
{
    protected $tag = 'input';
    
    protected $attributes = array('type' => 'checkbox');
    
    protected $isVoid = true; 
    
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
    
    public function __toString() 
    {   
        $content = '';
        
        foreach ($this->options as $label => $option) {
            $this->removeAttribute('checked');
            $this->setLabel($label);
            $this->setAttribute('value', $option);            
            
            if ($this->checkForPreSelection($option)) {
                $this->setAttribute('checked', 'checked');
            }         

            $content .= parent::__toString();
        }
        
        return $content;
    }
    
    public function getValidators()
    {
        $count = count($this->getOptions());
        if ($count > 1) {
            $this->addValidator(new Validator\InArray(array('haystack' => $this->getOptions())));
        }
        return $this->validators;
    }
}