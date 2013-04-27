<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Helper\Navigation;

use RecursiveIteratorIterator;

use Vision\Html\ElementFactory as Html;

/**
 * @author Frank Liepert
 */
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
    
    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }
    
    public function callHasChildren()
    {  
        if ($this->getDepth() > 0) {
            $current = $this->current();
            $pathInfo = $this->renderer->getRequest()->getPathInfo();
            $path = $current->getPath();
            $match = $this->renderer->matchPathWithPathInfo($path, $pathInfo);
            if ($match) {
                $current->match = true;
                if ($current->hasChildren()) {
                    $this->increaseMaxDepth();  
                }
            }
        }
        return parent::callHasChildren();
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
        $this->decreaseMaxDepth();
    }
    
    public function increaseMaxDepth()
    {
        $max = $this->getMaxDepth(); 
        $this->setMaxDepth(++$max); 
    }
    
    public function decreaseMaxDepth()
    {
        $max = $this->getMaxDepth(); 
        $this->setMaxDepth(--$max); 
    }
}