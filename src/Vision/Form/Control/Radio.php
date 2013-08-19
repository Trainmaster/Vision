<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Form\Control;

use Vision\Form\Decorator\Label;

class Radio extends MultiOptionControlAbstract 
{
    protected $tag = 'input';
    
    protected $attributes = array('type' => 'radio');
    
    protected $isVoid = true; 
    
    public function init() 
    {
        $this->addDecorator(new Label);
		$this->addClass('input-'.$this->getAttribute('type'));        
    }
    
    public function __toString() 
    {	
        $content = null;
        if ($this->view === null) {
            foreach ($this->options as $key => $value) {
                $label = new \Vision\Html\Element('label');
                $label->setContent($key);
                $label->setAttribute('for', $this->getName() . '-' . $value);
                $this->setAttribute('value', $value);
                $this->setAttribute('id', $this->getName() . '-' . $value);
                $radio = new \Vision\View\Html\Element($this);
                $li = new \Vision\Html\Element('li');
                $li->setContent($label . $radio);
                $content .= $li;  
            }            
        }
        foreach ($this->decorators as $decorator) {
            $decorator->setElement($this);
            $content = $decorator->render($content);
        }
        return $content;
	}
}