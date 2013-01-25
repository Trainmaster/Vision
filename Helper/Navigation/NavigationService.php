<?php
namespace Vision\Helper\Navigation;

use Vision\Http\Request;
use Vision\Html\Element as HtmlElement;
use SplFileObject;

class NavigationService 
{
    private $counter = 0;
    
    private $currentPath = null;
    
    protected $mapper;
    
    protected $request;
    
	public function __construct($mapper, Request $request) 
    {
		$this->mapper = $mapper;
        $this->request = $request;
        $this->currentPath = $this->request->getPath();
	}	
	
	public function getTreeById($id) 
    {    
        /*$hash = md5(__NAMESPACE__ . $id);
        
        $file = file_get_contents($hash . '.cache');
        
        if ($file !== false) {
            return $file;
        }*/
    
		$flatTree = $this->mapper->loadById($id);
		$tree = $this->convertToArrayTree($flatTree);
		$tree = $tree[$id];             
		$tree = $this->render($tree);	
        
        /*$string = (string) $tree;        
        $file = new SplFileObject($hash . '.cache', 'w');
        $file->fwrite($string);
        */
		return $tree;
	}
	
	public function convertToArrayTree(array $tree) 
    {
		foreach ($tree as $id => $row) {
			if ($row instanceof Node) {
				if (array_key_exists($row->getParent(), $tree)) {
					$tree[$row->getParent()]->setChild($id, $tree[$id]);		
				}
			} else {
				throw \Exception(sprintf('Tree element must be an instance of Node'));
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
        $li = new HtmlElement('li');

        if ($node->getShowLink()) {
            $a = new HtmlElement('a');
            $a->setAttribute('href', $this->request->getBaseUrl() . $node->getPath())
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

    public function matchWithCurrentPath($path) 
    {
        if ($path === $this->currentPath) {
            return true;
        } elseif (strlen($path) > 1 && strpos($this->currentPath, $path) !== false) {
            return true;
        } else {
            return false;
        }
    }
}