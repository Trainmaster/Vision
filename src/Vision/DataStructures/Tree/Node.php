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
 * Node
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Node
{
    /** @type null|int $id */
    protected $id = null;
    
    /** @type array $children */
    protected $children = array();

    /**
     * @api
     * 
     * @param self $child 
     * 
     * @return $this Provides a fluent interface.
     */
    public function addChild(self $child)
    {
        $this->children[] = $child;
        return $this;
    }
    
    /**
     * @api
     * 
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }
    
    /**
     * @api
     * 
     * @return bool
     */
    public function hasChildren()
    {
        return !empty($this->children);
    }
    
    /**
     * @api
     * 
     * @return array
     */
    public function resetChildren()
    {
        return $this->children = array();
    }
}