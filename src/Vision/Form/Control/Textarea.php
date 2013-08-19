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

/**
 * Textarea
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
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
    
    public function setValue($value) 
    {   
        $this->contents[] = $value;
		$this->value = $value;
		return $this;
	}
    
    public function isValid($value) 
    {
        if (parent::isValid($value) === true) {
            $this->contents[] = $this->getValue();
            return true;
        }
        return false;
    }
}