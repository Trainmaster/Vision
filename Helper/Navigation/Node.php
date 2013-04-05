<?php
namespace Vision\Helper\Navigation;

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

    public function setNavigationId($navigationId)
    {
        $this->navigationId = (int) $navigationId;
        return $this;
    }
    
    public function getNavigationId()
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
    
    public function setChild($id, $child)
    {
        $this->children[$id] = $child;
    }
    
    public function getChildren()
    {
        return $this->children;
    }
    
    public function hasChildren()
    {
        return (bool) !empty($this->children);
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
        if (isset($attributes)) {
            $attributes = json_decode($attributes, true);
            if ($attributes !== null) {
                $this->attributes = $attributes;
            }       
        }
        return $this;
    }
    
    public function getAttributes()
    {
        return $this->attributes;
    }
}