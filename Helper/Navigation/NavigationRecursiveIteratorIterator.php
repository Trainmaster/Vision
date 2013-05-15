<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Helper\Navigation;

use Vision\Html\ElementFactory as Html;

use RecursiveIteratorIterator;

/**
 * @author Frank Liepert
 */
class NavigationRecursiveIteratorIterator extends RecursiveIteratorIterator
{   
    /**
     * @param mixed $context 
     * 
     * @return \Vision\Helper\Navigation\NavigationRecursiveIteratorIterator Provides a fluent interface.
     */
    public function setContext(&$context)
    {
        $this->context = &$context;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getContext()
    {
        return $this->context;
    }    
    
    /**
     * @param \Vision\Helper\Navigation\NavigationRendererInterface $renderer 
     * 
     * @return \Vision\Helper\Navigation\NavigationRecursiveIteratorIterator Provides a fluent interface.
     */
    public function setRenderer(NavigationRendererInterface $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }
    
    /**
     * @return bool
     */
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

    /**
     * @return void
     */
    public function beginChildren() 
    {   
        $class = 'level-' . $this->getDepth();
        $this->context .= Html::create('ul')->addClass($class)->renderStartTag();
    }
    
    /**
     * @return void
     */
    public function endChildren()
    {   
        $this->context .= Html::create('ul')->renderEndTag();        
        if ($this->getDepth() > 1) {
            $this->context .= Html::create('li')->renderEndTag(); 
        }        
        $this->decreaseMaxDepth();
    }
    
    /**
     * @return void
     */
    public function increaseMaxDepth()
    {
        $max = $this->getMaxDepth(); 
        $this->setMaxDepth(++$max); 
    }
    
    /**
     * @return void
     */
    public function decreaseMaxDepth()
    {
        $max = $this->getMaxDepth(); 
        $this->setMaxDepth(--$max); 
    }
}