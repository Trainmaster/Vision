<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Extension\Navigation;

use Vision\DataStructures\Tree\Node as TreeNode;

/**
 * Node
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Node extends TreeNode
{
    /** @type null|int $id */
    protected $id = null;
    
    /** @type bool $showLink */
    protected $showLink = true;
    
    /** @type bool $isVisible */
    protected $isVisible = true;
    
    /** @type null|int $parent */
    protected $parentId = null;
    
    /** @type null|string $name */
    protected $name = null;
    
    /** @type null|string $path */
    protected $path = null;
    
    /** @type array $attributes */
    protected $attributes = array();
    
    /**
     * @param int $id 
     */
    public function __construct($id)
    {
        $this->id = (int) $id;
    }
    
    /** 
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }
    
    /**
     * @api
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @api
     * 
     * @param bool $showLink 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setShowLink($showLink)
    {
        $this->showLink = (bool) $showLink;
        return $this;
    }
    
    /**
     * @api
     * 
     * @return bool
     */
    public function showLink()
    {
        return $this->showLink;
    }
    
    /**
     * @api
     * 
     * @param bool $isVisible 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = (bool) $isVisible;
        return $this;
    }
    
    /**
     * @api
     * 
     * @return bool
     */
    public function isVisible()
    {
        return $this->isVisible;
    }
    
    /**
     * @api
     * 
     * @param int $parent 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setParentId($parentId)
    {   
        $this->parentId = (int) $parentId;
        return $this;
    }
    
    /**
     * @api
     * 
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }
    
    /**
     * @api
     * 
     * @param string $name 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setName($name)
    {
        $this->name = (string) $name;
        return $this;
    }
    
    /**
     * @api
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @api
     * 
     * @param string $path 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setPath($path)
    {
        $this->path = (string) $path;
        return $this;
    }
    
    /**
     * @api
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * @api
     * 
     * @param array $attributes 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }
    
    /**
     * @api
     * 
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}