<?php
namespace Vision\Helper\Navigation;

use Vision\Http\RequestInterface;
use Vision\Html\Element as HtmlElement;
use SplFileObject;
use RuntimeException;

class NavigationService 
{     
    /**
     * Node ID as root.
     *
     * @var null|int
     */
    protected $rootId = null;
    
    /**
     * Language ID.
     *
     * @var null|int
     */
    protected $languageId = null;
    
    /**
     * Reference to NavigationMapper instance.
     *
     * @var NavigationMapper
     */
    protected $mapper = null;
    
    /**
     * Reference to Request instance.
     *
     * @var RequestInterface
     */
    protected $request = null;
    
    /**
     * Reference to NavigationRenderer instance.
     *
     * @var NavigationRenderer
     */
    protected $renderer = null;
     
    /**
     * @param object $mapper 
     * @param object $renderer 
     * 
     * @return void
     */
    public function __construct($mapper, $renderer)
    {
        $this->setMapper($mapper);
        $this->setRenderer($renderer);
    }
    
    /**
     * @return string 
     */
    public function __toString()
    {
        $tree = $this->prepareTree();
        $this->renderer->setRequest($this->request);
        $tree = $this->renderer->render($tree);
        return (string) $tree;
    }
    
    /**
     * Setter for $request property.
     * 
     * @param RequestInterface $request 
     * 
     * @return NavigationService Provides a fluent interface.
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
        return $this;
    }
        
    /**
     * Setter for $rootId property.
     * 
     * @param int $id 
     * 
     * @return NavigationService Provides a fluent interface.
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
     * @return NavigationService Provides a fluent interface.
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
     * @return NavigationService Provides a fluent interface.
     */
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }
    
    /**
     * Setter for $renderer property.
     * 
     * @param NavigationRendererInterface $renderer 
     * 
     * @return NavigationService Provides a fluent interface.
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
        $cache = file_get_contents('XYZ.cache');        
        if ($cache !== false) {
            return unserialize($cache);
        }
        */
        
        if ($this->rootId === null) {
            throw RuntimeException('A root id must be set.');
        }
        
        if ($this->languageId === null) {
            throw RuntimeException('A language id id must be set.');
        }       

        $flatTree = $this->mapper->loadByIdAndLanguageId($this->rootId, $this->languageId);
        
        if ($flatTree === null) {
            throw RuntimeException('No tree found.');
        }
        
        $tree = $this->convertFlatToHierarchical($flatTree);
        
        if (!array_key_exists($this->rootId, $tree)) {
            throw RuntimeException('Something went wrong.');
        }
        
        $tree = array($this->rootId => $tree[$this->rootId]);
        
        /*
        $cache = serialize($tree);        
        $file = new SplFileObject('XYZ.cache', 'w');
        $file->fwrite($cache);
        */ 
        
        return $tree;        
    }

    /**
     * Converts flat array to hierarchical array.
     * 
     * @param array $data 
     * 
     * @return NavigationService Provides a fluent interface.
     */
    protected function convertFlatToHierarchical(array $data)
    {
        foreach ($data as $id => $row) {
            if ($row instanceof Node) {
                if (array_key_exists($row->getParent(), $data)) {
                    $data[$row->getParent()]->setChild($id, $data[$id]);        
                }
            } else {
                throw RuntimeException(sprintf('Tree element must be an instance of Node'));
            }
        }       
        return $data;
    }
}