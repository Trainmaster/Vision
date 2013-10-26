<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Extension\Navigation;

use Vision\Cache\CacheInterface;
use Vision\Html\Element as HtmlElement;
use Vision\Http\RequestInterface;
use Vision\Routing\Route;

use SplFileObject;
use RuntimeException;
use InvalidArgumentException;

/**
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Navigation 
{        
    /** @type int $rootId */
    protected $rootId = null;
    
    /** @type int $languageId */
    protected $languageId = null;
    
    /** @type CacheInterface $cache */
    protected $cache = null;
    
    /** @type NavigationMapperInterface $mapper */
    protected $mapper = null;
    
    /** @type NavigationRendererInterface $renderer */
    protected $renderer = null;
    
    /** @type RequestInterface $request */
    protected $request = null;
    
    /**
     * Constructor
     *
     * @param NavigationMapperInterface $mapper 
     * @param NavigationRendererInterface $renderer 
     * @param RequestInterface $request 
     */
    public function __construct(NavigationMapperInterface $mapper, 
                                NavigationRendererInterface $renderer, 
                                RequestInterface $request)
    {
        $this->setMapper($mapper);
        $this->setRenderer($renderer);
        $this->request = $request;
    }
    
    /**
     * @return string 
     */
    public function __toString()
    {
        $tree = $this->loadTree();
        
        $this->markActiveBranch($tree);
        
        if (!($tree instanceof Node)) {
            return '';
        }
        
        return $this->renderer->render($tree);
    }
    
    /**
     * Setter for $mapper property.
     * 
     * @param object $mapper 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setMapper(NavigationMapperInterface $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }
    
    /**
     * Setter for $renderer property.
     * 
     * @param NavigationRendererInterface $renderer 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setRenderer(NavigationRendererInterface $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }
    
    /**
     * @api
     * 
     * @param CacheInterface $cache 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
        return $this;
    }   
        
    /**
     * Setter for $rootId property.
     * 
     * @param int $id 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setRootId($id)
    {
        $this->rootId = (int) $id;
        return $this;
    }
    
    /**
     * Setter for $languageId property.
     * 
     * @param int $id 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setLanguageId($id)
    {
        $this->languageId = (int) $id;
        return $this;
    }
    
    /**
     * @api
     * 
     * @param int $fromDepth 
     * 
     * @return Navigation Provides a fluent interface.
     */
    public function fromDepth($fromDepth)
    {
        $this->renderer->fromDepth($fromDepth);
        return $this;
    }

    /**
     * @api
     * 
     * @param int $limitDepth 
     *
     * @throws InvalidArgumentException
     *     
     * @return Navigation Provides a fluent interface.
     */
    public function limitDepth($limitDepth)
    {
        if ($limitDepth < -1 || $limitDepth === 0) {
            throw new InvalidArgumentException('Valid values: -1 or > 0');
        }
        
        $this->renderer->limitDepth($limitDepth);
        return $this;
    }

    /**
     * @api
     * 
     * @param int $expandBy 
     * 
     * @throws InvalidArgumentException
     *
     * @return Navigation Provides a fluent interface.
     */
    public function expandBy($expandBy)
    {
        if ($expandBy < -1 || $expandBy === 0) {
            throw new InvalidArgumentException('Valid values: -1 or > 0');
        }
        
        $this->renderer->expandBy($expandBy);
        return $this;
    }
    
    /**
     * @api
     * 
     * @param bool $link 
     * 
     * @return Navigation Provides a fluent interface.
     */
    public function link($link)
    {
        $this->renderer->link((bool) $link);
        return $this;
    }
    
    /**
     * Alias for __toString() 
     *
     * @api
     * 
     * @return string
     */
    public function render()
    {
        return $this->__toString();
    }
    
    /**
     * Load the tree from either the mapper or the cache (optional).
     *
     * @return null|Node
     */
    protected function loadTree()
    {
        if (!isset($this->rootId, $this->languageId)) {
            return null;
        }

        $key = md5($this->rootId . $this->languageId);
        
        $data = null;
        
        if (isset($this->cache)) {
            $data = $this->cache->get($key);
            if ($data instanceof Node) {
                return $data;
            }
        }
        
        if (!isset($data)) {
            $data = $this->mapper->loadByIdAndLanguageId($this->rootId, $this->languageId);
            if (!($data instanceof Node)) {
                return null;
            }
        }
        
        $tree = new Node(null);
        $tree->addChild($data);
        
        if (isset($this->cache)) {
            $this->cache->set($key, $tree);
        }
        
        return $tree;        
    }
    
    /**
     * Traverse nodes and find the node best matching with the current request.
     * 
     * @param Node $node 
     * 
     * @return void
     */
    protected function markActiveBranch(Node $node)
    {
        $pathInfo = $this->request->getPathInfo();
        
        $nodeIterator = new \Vision\DataStructures\Tree\NodeIterator($node);
        $iterator = new \RecursiveIteratorIterator($nodeIterator, \RecursiveIteratorIterator::SELF_FIRST);
        
        foreach ($iterator as $node) {
            $url = $node->getPath();
            if ($url === $pathInfo) {
                $this->markParent($node);
            }
        }
    }
    
    /**
     * Recursively find all nodes in the active branch and mark them as active.
     * 
     * @param Node $node 
     * 
     * @return void
     */
    protected function markParent(Node $node)
    {        
        $parent = $node->getParent();
        $node->isActive = true;
        if ($parent !== null) {        
            $this->markParent($parent);
        }
    }
}