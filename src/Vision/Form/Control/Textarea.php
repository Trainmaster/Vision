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
    /** @type string $tag */
    protected $tag = 'textarea';
    
    /**
     * @return void
     */    
    public function init() 
    {
        $this->addDecorator(new Decorator\Label)
             ->addDecorator(new Decorator\Li);
        $this->setAttribute('id', $this->getName());
        $this->addClass('input-textarea');
    }
    
    /**
     * @api
     * 
     * @param int $rows 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setRows($rows) 
    {
        $this->setAttribute('rows', (int) $rows);
        return $this;
    }
    
    /**
     * @api
     * 
     * @param int $cols 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setCols($cols) 
    {
        $this->setAttribute('cols', (int) $cols);
        return $this;
    }
    
    /**
     * @api
     * 
     * @param mixed $value 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setValue($value) 
    {   
        $this->contents[] = $value;
		$this->value = $value;
		return $this;
	}
    
    /**
     * @api
     * 
     * @param mixed $value 
     * 
     * @return bool
     */
    public function isValid($value) 
    {
        if (parent::isValid($value) === true) {
            $this->contents[] = $this->getValue();
            return true;
        }
        return false;
    }
}