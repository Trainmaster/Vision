<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Helper\Navigation;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;

use Vision\Html\ElementFactory as Html;

/**
 * @author Frank Liepert
 */
class NavigationRenderer implements NavigationRendererInterface
{    
    /**
     * @type null|Request $request
     */
    protected $request = null;
    
    public function setRequest($request)
    {
        $this->request = $request;
    }
    
    public function getRequest()
    {
        return $this->request;
    }
    
    public function render(array $tree)
    {
        $html = '';
        
        $basePath = $this->request->getBasePath();
        $pathInfo = $this->request->getPathInfo();
        
        $nodeIterator = new NodeIterator($tree);

        $iterator = new NavigationRecursiveIteratorIterator($nodeIterator, RecursiveIteratorIterator::SELF_FIRST);
        
        $iterator->setContext($html);
        $iterator->setMaxDepth(1);
        $iterator->setRenderer($this);
        
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

                if (isset($node->match)) {
                    $li->addClass('active');
                }
                
                if ($iterator->hasChildren()) {
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