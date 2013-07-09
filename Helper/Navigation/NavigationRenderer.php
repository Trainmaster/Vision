<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Helper\Navigation;

use Vision\Html\Element;
use Vision\Http\RequestInterface;
use RecursiveCachingIterator;
use RecursiveIteratorIterator;

/**
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class NavigationRenderer implements NavigationRendererInterface
{
    /** @type RequestInterface $request */
    protected $request = null;
    
    /** @type int $fromDepth */
    protected $fromDepth = 0;

    /** @type int $limitDepth */
    protected $limitDepth = -1;
    
    /** @type int $expandBy */
    protected $expandBy = -1;
    
    /** @type bool $link */
    protected $link = false;
    
    /**
     * Constructor
     *
     * @param RequestInterface $request 
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }
    
    /**
     * @api
     * 
     * @param int $fromDepth 
     * 
     * @return NavigationRenderer Provides a fluent interface.
     */
    public function fromDepth($fromDepth)
    {
        $this->fromDepth = (int) $fromDepth;
        return $this;
    }
    
    /**
     * @api
     * 
     * @param int $limitDepth 
     * 
     * @return NavigationRenderer Provides a fluent interface.
     */
    public function limitDepth($limitDepth)
    {
        $this->limitDepth = (int) $limitDepth;
        return $this;
    }
    
    /**
     * @api
     * 
     * @param int $expandBy 
     * 
     * @return NavigationRenderer Provides a fluent interface.
     */
    public function expandBy($expandBy)
    {
        $this->expandBy = $expandBy;
        return $this;
    }
    
    /**
     * @api
     * 
     * @param bool $link 
     * 
     * @return NavigationRenderer Provides a fluent interface.
     */
    public function link($link)
    {
        $this->link = (bool) $link;
        return $this;
    }
    
    /**
     * @api
     *
     * @param array $tree A multidimensional tree of Nodes.
     * 
     * @return string
     */
    public function render(array $tree)
    {    
        $basePath = $this->request->getBasePath();
        
        $nodeIterator = new NodeIterator($tree);
        $cachingIterator = new RecursiveCachingIterator($nodeIterator);
        $iterator = new RecursiveIteratorIterator($cachingIterator, RecursiveIteratorIterator::SELF_FIRST);
        
        $fromDepth = $this->fromDepth;
        $limitDepth = $this->limitDepth;
        $expandBy = $this->expandBy;
        $link = $this->link;
        
        $actives = array();
        $lastDepth = $fromDepth - 1;
        
        if ($limitDepth > 0) {
            $iterator->setMaxDepth($fromDepth + $limitDepth - 1);
        }

        foreach ($iterator as $node) {
            
            $depth = $iterator->getDepth();
            $maxDepth = $iterator->getMaxDepth();
            
            $url = $node->getPath();

            if (isset($node->isActive)) {
                $actives[$node->getNavigationId()] = $depth;
            }
            
            if ($maxDepth === false) {
                $maxDepth = -1;
            }
            
            if ($maxDepth >= 0 && $depth > $maxDepth) {
                continue;
            }
            
            if ($depth < $fromDepth) {
                continue;
            }

            if ($link && $fromDepth > 0 && !array_key_exists($node->getParent(), $actives)) {
                $iterator->current()->resetChildren();
                continue;
            }
            
            if (empty($actives)) {
                $iterator->setMaxDepth($depth);
                $iterator->current()->resetChildren();
            } elseif ($depth > max($actives) && !array_key_exists($node->getParent(), $actives)) {
                continue;
            }
            
            if ($depth > $lastDepth) {
                if (isset($ul)) {
                    $content = $ul;
                }
                
                $ul = new Element('ul');
                
                if (isset($content)) {
                    $ul->addContent($content);
                    $content = null;
                }

                $ul->addClass('level-' . $depth);
            }

            if ($iterator->hasNext()) {
                if ($depth > $lastDepth) {
                    $class = 'first-item';
                } else {
                    $class = null;
                }
            } else {
                if ($depth > $lastDepth) {
                    $class = 'foreverAlone-item';
                } else {
                    $class = 'last-item';
                }                
            }

            if ($node->isVisible()) {
                if ($node->showLink()) {
                    $element = new Element('a');
                    
                    if (parse_url($url, PHP_URL_SCHEME)) {
                        $href = $url;
                        $element->setAttribute('target', '_blank');
                    } else {
                        $href = $basePath . $url;
                    }             
                    
                    $element->setAttribute('href', $href)
                            ->addContent($node->getName());
                } else {
                    $element = new Element('span');
                    $element->addContent($node->getName());
                }
            } else {
                $element = null;
            }
            
            $li = new Element('li');
            $li->addContent($element);
            
            if (isset($class)) {
                $li->addClass($class);
            }
                
            $attributes = $node->getAttributes();
        
            if (!empty($attributes)) {
                $li->setAttributes($attributes);
            }

            if (isset($node->isActive)) {
                $li->addClass('active');
            }
            
            $ul->addContent($li);
            
            $lastDepth = $depth;           
        }

        return (isset($ul) ? (string) $ul : '');
    }
}