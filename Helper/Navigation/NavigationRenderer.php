<?php
namespace Vision\Helper\Navigation;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;

use Vision\Html\ElementFactory as Html;

class NavigationRenderer implements NavigationRendererInterface
{    
    protected $request = null;
    
    protected $pathInfo = null;
    
    public function setRequest($request)
    {
        $this->request = $request;
    }
    
    public function render($tree)
    {
        $this->pathInfo = $this->request->getPathInfo();
        $this->basePath = $this->request->getBasePath();
    
        $html = '';
        
        $nodeIterator = new NodeIterator($tree);

        $iterator = new NavigationRecursiveIteratorIterator($nodeIterator, RecursiveIteratorIterator::SELF_FIRST);
        $iterator->setContext($html);
        
        foreach ($iterator as $node) {          
            
            $path = $node->getPath();
            
            if ($node->isVisible() && $node->showLink()) {
                $element = Html::create('a');
                $element->setAttribute('href', $this->basePath . $path)
                        ->setContent($node->getName());
            } elseif ($node->isVisible() && $node->showLink() === false) {
                $element = Html::create('span');
                $element->setContent($node->getName());
            }

            if (isset($element)) {
                $li = Html::create('li')->setContent($element);
                
                if ($this->matchWithPathInfo($path)) {
                    $li->addClass('active');
                }
                
                if ($iterator->callHasChildren()) {
                    var_dump(true);
                    $html .= $li->renderStartTag() . $li->getContent();
                } else {
                    $html .= $li;
                }                
                //var_dump($iterator->endChildren());               
            }
        }
        
        return $html;
    }
    
    
    public function matchWithPathInfo($path) 
    {               
        if ($path === $this->pathInfo) {
            return true;
        } elseif (strlen($path) > 1 && strpos($this->pathInfo, $path) !== false) {
            return true;
        }
        return false;
    }
}