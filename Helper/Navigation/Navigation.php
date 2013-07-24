<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Helper\Navigation;

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
    
    /** @type NavigationMapper $mapper */
    protected $mapper = null;
    
    /** @type NavigationRenderer $renderer */
    protected $renderer = null;
    
    /** @type RequestInterface $request */
    protected $request = null;
    
    /** @type Route $route */
    protected $route = null;
     
    /**
     * Constructor
     *
     * @param NavigationMapperInterface $mapper 
     * @param NavigationRendererInterface $renderer 
     * @param RequestInterface $request 
     * @param Route $route 
     */
    public function __construct(NavigationMapperInterface $mapper, NavigationRendererInterface $renderer, 
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
        $tree = $this->prepareTree();
        $tree = $this->renderer->render($tree);
        return (string) $tree;
    }
    
    public function render()
    {
        return (string) $this;
    }
    
    public function setRoute(Route $route)
    {
        $this->route = $route;
        return $this;
    }
        
    /**
     * Setter for $rootId property.
     * 
     * @param int $id 
     * 
     * @return Navigation Provides a fluent interface.
     */
    public function setRootId($id)
    {
        $this->rootId = (int) $id;
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
     * Setter for $languageId property.
     * 
     * @param int $id 
     * 
     * @return Navigation Provides a fluent interface.
     */
    public function setLanguageId($id)
    {
        $this->languageId = (int) $id;
        return $this;
    }

    /**
     * Setter for $mapper property.
     * 
     * @param object $mapper 
     * 
     * @return Navigation Provides a fluent interface.
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
     * @return Navigation Provides a fluent interface.
     */
    public function setRenderer(NavigationRendererInterface $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }
    
    /**
     * Prepares the tree.
     * 
     * @todo Implement caching mechanism (see inline comments).
     *
     * @throws RuntimeException
     *
     * @return array $tree
     */
    protected function prepareTree()
    {
        /*
        $cache = file_get_contents('example.cache');        
        if ($cache !== false) {
            return unserialize($cache);
        }
        */
        
        if ($this->rootId === null) {
            throw new RuntimeException('A root id must be set.');
        }
        
        if ($this->languageId === null) {
            throw new RuntimeException('A language id must be set.');
        }       

        $flatTree = $this->mapper->loadByIdAndLanguageId($this->rootId, $this->languageId);
        
        if ($flatTree === null) {
            throw new RuntimeException('No tree found.');
        }
        
        $flatTree = $this->findLatestActiveNode($flatTree);       
        
        $tree = $this->convertFlatToHierarchical($flatTree);
        
        if (!array_key_exists($this->rootId, $tree)) {
            throw new RuntimeException('Something went wrong.');
        }
        
        $tree = array($tree[$this->rootId]);
        
        /*
        $cache = serialize($tree);        
        $file = new SplFileObject('example.cache', 'w');
        $file->fwrite($cache);
        */ 
        
        return $tree;        
    }

    /**
     * Converts flat array to hierarchical array.
     * 
     * @param array $data 
     * 
     * @return array $data
     */
    protected function convertFlatToHierarchical(array $data)
    {
        foreach ($data as $row) {
            if ($row instanceof Node) {
                $parent = $row->getParent();
                if (array_key_exists($parent, $data)) {
                    $data[$parent]->addChild($row);        
                }
            } else {
                throw new RuntimeException('Array element must be an instance of Node.');
            }
        }      
        
        return $data;
    }
    
    /**
     * Iterate nodes and find node(s) matching with the current request.
     * 
     * @param array $data 
     * 
     * @return array
     */
    protected function findLatestActiveNode(array $data)
    {
        $pathInfo = $this->request->getPathInfo();
        
        if (isset($this->route) && !$route->isStatic()) {
            $pathInfo = $route->getStaticPath();
        }
        
        foreach ($data as $row) {
            $url = $row->getPath();
            if ($url === $pathInfo) {
                $row->isActive = true;
                $this->markParent($data, $row->getParent());
            }
        }
        
        return $data;
    }
    
    /**
     * Recursively find all nodes in the active branch and mark them as active.
     * 
     * @param array $data 
     * @param int $id 
     * 
     * @return void
     */
    protected function markParent(array $data, $id)
    {
        if (isset($data[$id])) {
            $data[$id]->isActive = true;
            $parent = $data[$id]->getParent();
            if ($id !== $parent) {
                $this->markParent($data, $parent);
            }
        }
    }
}