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
    
    protected $isVoidElement = true;
    
    public function init() 
    {
        $this->addDecorator(new Decorator\Label)
             ->addDecorator(new Decorator\Li);
    }
    
    public function __toString() 
    {	
        $content = '';
        foreach ($this->options as $key => $value) {
            $this->setLabel($key);
            $this->setAttribute('value', $value);
            if ($this->getValue() !== null) {
                if (in_array($value, $this->getValue())) {
                    $this->setAttribute('checked', 'checked');
                }
            }
            $content .= parent::__toString();
        }
        return $content;
	}
    
    public function getValidators() {
        $this->addValidator(new Validator\InArray(array('haystack' => $this->getOptions())));
        return $this->validators;
    }
}