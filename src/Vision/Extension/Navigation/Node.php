<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Extension\Navigation;

/**
 * Node
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Node
{
    protected $navigationId = null;
    
    protected $showLink = true;
    
    protected $isVisible = true;
    
    protected $parent = null;
    
    protected $name = null;
    
    protected $path = null;
    
    protected $attributes = array();
    
    protected $children = array();

    public function __construct($navigationId)
    {
        $this->setNavigationId($navigationId);
    }
    
    public function __toString()
    {
        return $this->name;
    }

    public function setNavigationId($navigationId)
    {
        $this->navigationId = (int) $navigationId;
        return $this;
    }
    
    public function getNavigationId()
    {
        return $this->navigationId;
    }
    
    public function getId()
    {
        return $this->navigationId;
    }
    
    public function setShowLink($showLink)
    {
        $this->showLink = (bool) $showLink;
        return $this;
    }
    
    public function showLink()
    {
        return $this->showLink;
    }
    
    public function setIsVisible($isVisible)
    {
        $this->isVisible = (bool) $isVisible;
        return $this;
    }
    
    public function isVisible()
    {
        return $this->isVisible;
    }
    
    public function setParent($parent)
    {   
        $this->parent = (int) $parent;
        return $this;
    }
    
    public function getParent()
    {
        return $this->parent;
    }
    
    public function addChild(self $child)
    {
        $this->children[] = $child;
    }
    
    public function getChildren()
    {
        return $this->children;
    }
    
    public function hasChildren()
    {
        return (bool) !empty($this->children);
    }
    
    public function resetChildren()
    {
        return $this->children = array();
    }
    
    public function setName($name)
    {
        $this->name = (string) $name;
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setPath($path)
    {
        $this->path = (string) $path;
        return $this;
    }
    
    public function getPath()
    {
        return $this->path;
    }
    
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }
    
    public function getAttributes()
    {
        return $this->attributes;
    }
}