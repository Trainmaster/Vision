<?php
namespace Vision\Form\Control;

use Vision\Form\Decorator;

class Textarea extends ControlAbstract 
{
    protected $tag = 'textarea';
    
    public function init() 
    {
        $this->addDecorator(new Decorator\Label)
             ->addDecorator(new Decorator\Li);
        $this->setAttribute('id', $this->getName());
        $this->addClass('input-textarea');
    }
    
    public function setRows($rows) 
    {
        $this->setAttribute('rows', (int) $rows);
        return $this;
    }
    
    public function setCols($cols) 
    {
        $this->setAttribute('cols', (int) $cols);
        return $this;
    }
    
    public function isValid($value) 
    {
        if (parent::isValid($value) === true) {
            $this->content = $this->getValue();
            return true;
        }
        return false;
    }
}