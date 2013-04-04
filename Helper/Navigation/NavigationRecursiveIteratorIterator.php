<?php
namespace Vision\Helper\Navigation;

use RecursiveIteratorIterator;

use Vision\Html\ElementFactory as Html;

class NavigationRecursiveIteratorIterator extends RecursiveIteratorIterator
{
    public function setContext(&$context)
    {
        $this->context = &$context;
    }
    
    public function getContext()
    {
        return $this->context;
    }

    public function beginChildren() 
    {
        $class = 'level-' . $this->getDepth();
        $this->context .= Html::create('ul')->addClass($class)->renderStartTag();
    }
    
    public function endChildren()
    {   
        $this->context .= Html::create('ul')->renderEndTag();
        if ($this->getDepth() > 1) {
            $this->context .= Html::create('li')->renderEndTag(); 
        }
    }
}