<?php
namespace Vision\Form\Control;

abstract class MultiOptionControlAbstract extends ControlAbstract 
{
	protected $options = array();
    
    public function setOptions(array $options) 
    {
        $this->options = $options;
        return $this;
    }
    
    public function getOptions() 
    {
        return $this->options;
    }
}