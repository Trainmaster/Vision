<?php
namespace Vision\Helper\Navigation;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;

use Vision\Html\ElementFactory as Html;

class NavigationRenderer implements NavigationRendererInterface
{    
    protected $request = null;
    
    public function setRequest($request)
    {
        $this->request = $request;
    }
    
    public function render($tree)
    {
        $html = '';
        
        $basePath = $this->request->getBasePath();
        $pathInfo = $this->request->getPathInfo();
        
        $nodeIterator = new NodeIterator($tree);

        $iterator = new NavigationRecursiveIteratorIterator($nodeIterator, RecursiveIteratorIterator::SELF_FIRST);
        
        $iterator->setContext($html);
        
        foreach ($iterator as $node) {        
            
            $depth = $iterator->getDepth();
            $path = $node->getPath();  

            if ($node->isVisible() && $node->showLink()) {
                $element = Html::create('a');
                $element->setAttribute('href', $basePath . $path)
                        ->setContent($node->getName());
            } elseif ($node->isVisible() && $node->showLink() === false) {
                $element = Html::create('span');
                $element->setContent($node->getName());
            } else {
                $element = null;
            }
            
            if ($depth > 0) {            
                $li = Html::create('li')->setContent($element);
                
                $attributes = $node->getAttributes();
            
                if (!empty($attributes)) {
                    $li->setAttributes($attributes);
                }

                if ($this->matchPathWithPathInfo($path, $pathInfo)) {
                    $li->addClass('active');
                }
                
                if ($iterator->callHasChildren()) {
                    $html .= $li->renderStartTag() . $li->getContent();
                } else {
                    $html .= $li;
                }
                
                unset($element);
            } else {
                $html .= $element;
            }            
        }
        
        return $html;
    }
    
    
    public function matchPathWithPathInfo($path, $pathInfo) 
    {               
        if ($path === $pathInfo) {
            return true;
        } elseif (strlen($path) > 1 && strpos($pathInfo, $path) !== false) {
            return true;
        }
        return false;
    }
}