<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\DataStructures\Tree;

/**
 * @author Frank Liepert
 */
class NodeIterator implements \RecursiveIterator 
{
    /** @type array $nodes */
    private $nodes;
    
    /**
     * @param NodeInterface $node 
     */
    public function __construct(NodeInterface $node) 
    {
        $this->nodes = $node->getChildren();
    }
    
    public function hasChildren()
    {
        return $this->current()->hasChildren();
    }
    
    public function getChildren()
    {
        return new self($this->current());
    }   
    
    public function current()
    {
        return $this->nodes[$this->position];
    }
    
    public function key()
    {
        return $this->position;
    }
    
    public function next()
    {
        $this->position++;
    }
    
    public function rewind()
    {
        $this->position = 0;
    }   
    
    public function valid()
    {
        return isset($this->nodes[$this->position]);
    }
}