<?php
namespace Vision\Helper\Navigation;

use Vision\Http\RequestInterface;
use Vision\Html\Element as HtmlElement;
use SplFileObject;
use RuntimeException;

class NavigationService 
{
    private $counter = 0;
    
    private $currentPath = null;
    
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
    
	public function getTreeById($id, $languageId = 1) 
    {    
        /*$hash = md5(__NAMESPACE__ . $id);
        
        $file = file_get_contents($hash . '.cache');
        
        if ($file !== false) {
            return $file;
        }*/
    
		$flatTree = $this->mapper->loadById($id, $languageId);
		$tree = $this->convertToArrayTree($flatTree);
		$tree = $tree[$id];             
		$tree = $this->render($tree);	
        
        /*$string = (string) $tree;        
        $file = new SplFileObject($hash . '.cache', 'w');
        $file->fwrite($string);
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
    
    // old
	public function convertToArrayTree(array $tree) 
    {
		foreach ($tree as $id => $row) {
			if ($row instanceof Node) {
				if (array_key_exists($row->getParent(), $tree)) {
					$tree[$row->getParent()]->setChild($id, $tree[$id]);		
				}
			} else {
				throw RuntimeException(sprintf('Tree element must be an instance of Node'));
			}
		}		
		return $tree;
	}
    
    private function render(Node $node) 
    {
        $this->counter = 0;
        if ($node->isVisible() === true) {
            $ul = new HtmlElement('ul');
            $ul->setAttribute('class', 'level-' . $this->counter);        
            $this->counter++;
            $ul->setContent($this->renderListItems(array($node)));
            return $ul;
        } else {
            return $this->renderList($node);
        }
    }
	
	private function renderList(Node $node) 
    {      
        if ($node->hasVisibleChildren() === false) {
            return null;
        }        
        
        $ul = new HtmlElement('ul');

        $ul->setAttribute('class', 'level-' . $this->counter);
        
        $this->counter++;
        
        $ul->setContent($this->renderListItems($node->getChildren()));
        
        $this->counter--;
        
        return $ul;
	}
    
    private function renderListItems(array $listItems) 
    {        
        $html = '';
        
        foreach ($listItems as $listItem) {
            $html .= $this->renderListItem($listItem);
        }
        
        return $html;
    }
    
    private function renderListItem(Node $node) 
    {    
        if ($node->isVisible()) {
            $li = new HtmlElement('li');

            if ($node->getShowLink()) {
                $a = new HtmlElement('a');
                $a->setAttribute('href', $this->request->getBasePath() . $node->getPath())
                  ->setContent($node->getName());                
                $li->setContent($a);
            } else {
                $li->setContent($node->getName());
            }
                    
            $attributes = $node->getAttributes();
            
            if (!empty($attributes)) {
                $li->setAttributes($attributes);
            }
            
            if ($this->matchWithCurrentPath($node->getPath())) {
                if ($li->getAttribute('class') !== null) {
                    $li->setAttribute('class', $li->getAttribute('class') . ' active');
                } else {
                    $li->setAttribute('class', 'active');
                }
            }        
            
            $li->setContent($li->getContent() . $this->renderList($node));
            
            return $li;
        }
        return null;       
    }
}