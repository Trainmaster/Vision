<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Form\Iterator;

use RecursiveIterator;
use Vision\Form\Control\ControlAbstract;

/**
 * FormElementsIterator
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class FormElementsIterator implements RecursiveIterator
{
    private $elements;
    
    private $current;
    
    public function __construct($elements) 
    {
        $this->elements = $elements;
    }
    
    public function hasChildren()
    {   
        if ($this->elements[$this->current] instanceof ControlAbstract) {
            return false;
        }
        return count($this->elements[$this->current]) > 0;
    }
    
    public function getChildren()
    {
        return new self($this->elements[$this->current]->getElements());
    }   
    
    public function current()
    {
        return $this->elements[$this->current];
    }
    
    public function key()
    {
        return $this->current;
    }
    
    public function next()
    {
        ++$this->current;
    }
    
    public function rewind()
    {
        $this->current = 0;
    }   
    
    public function valid()
    {
        return isset($this->elements[$this->current]);
    }
}