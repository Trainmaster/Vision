<?php
namespace Vision\Helper\Navigation;

use Vision\Http\RequestInterface;
use Vision\Html\Element as HtmlElement;
use SplFileObject;
use RuntimeException;

class NavigationService 
{        
    protected $rootId = null;
    
    protected $languageId = null;
    
    protected $mapper = null;
    
    protected $request = null;
    
    protected $renderer = null;
    
    public function __construct($mapper, $renderer)
    {
        $this->setMapper($mapper);
        $this->setRenderer($renderer);
    }
    
    public function __toString()
    {
        $tree = $this->prepareTree();
        $this->renderer->setRequest($this->request);
        $tree = $this->renderer->render($tree);
        return (string) $tree;
    }
    
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
        return $this;
    }
        
    public function setRootId($id)
    {
        $this->rootId = (int) $id;
        return $this;
    }
    
    public function setLanguageId($id)
    {
        $this->languageId = (int) $id;
        return $this;
    }
    
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }
    
    public function setRenderer(NavigationRendererInterface $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }
    
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