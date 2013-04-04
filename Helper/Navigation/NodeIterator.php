<?php
namespace Vision\Helper\Navigation;

use RecursiveIterator;

class NodeIterator implements RecursiveIterator
{
    private $nodes;
    
    public function __construct($nodes) 
    {
        $this->nodes = $nodes;
    }
    
    public function hasChildren()
    {   
        return count($this->current()->getChildren()) > 0;
    }
    
    public function getChildren()
    {
        return new self($this->current()->getChildren());
    }   
    
    public function current()
    {
        return current($this->nodes);
    }
    
    public function key()
    {
        return key($this->nodes);
    }
    
    public function next()
    {
        next($this->nodes);
    }
    
    public function rewind()
    {
        reset($this->nodes);
    }   
    
    public function valid()
    {
        return isset($this->nodes[$this->key()]);
    }
}