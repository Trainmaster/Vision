<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Extension\Navigation;

use RecursiveIterator;

/**
 * @author Frank Liepert
 */
class NodeIterator implements RecursiveIterator 
{
    private $nodes;

    public function __construct($nodes) 
    {
        $this->nodes = $nodes;
    }
    
    public function hasChildren()
    {   
        return $this->nodes[$this->position]->hasChildren();
    }
    
    public function getChildren()
    {
        return new self($this->current()->getChildren());
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