<?php
namespace Vision\Routing;

class Route
{
    protected $hasPlaceholder = false;
    
    protected $path = null;
    
    protected $controller = null;
    
    protected $requirements = array();
    
    protected $defaults = array();
    
    public function __construct($path, $controller)
    {        
        $this->setPath($path);
        $this->setController($controller);
    }
	
    public function hasPlaceholder()
    {
        return $this->hasPlaceholder;
    }
    
    public function setPath($path)
    {
        if (strpos($path, '{') !== false) {
            $this->hasPlaceholder = true;
        }
        $this->path = trim($path);
        return $this;
    }
    
    public function getPath()
    {
        return $this->path;
    }

    public function setController($controller)
    {
        $this->controller = trim($controller);
        return $this;
    }
    
    public function getController()
    {
        return $this->controller;
    }
    
    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;
        return $this;
    }

    public function getDefaults()
    {
        return $this->defaults;
    }
    
    public function setRequirements(array $requirements)
    {
        $this->requirements = $requirements;
        return $this;
    }

    public function getRequirements()
    {
        return $this->requirements;
    }
}