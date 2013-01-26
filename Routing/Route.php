<?php
namespace Vision\Routing;

class RouteException extends \Exception {}

class Route {
    
    private $name = null;
    
    private $pattern = null;
    
    private $controller = null;
    
    private $requirements = array();
    
    private $defaults = array();
    
    private $extras = array();
    
    public function __construct($name, $pattern, $controller)
    {        
        if (isset($name)) {
            $this->setName($name);
        } else {
            throw new RouteException('Name must be specified.');
        }

        if (isset($pattern)) {
            $this->setPattern($pattern);
        } else {
            throw new RouteException('Pattern must be specified.');
        }

        if (isset($controller)) {
            $this->setController($controller);
        } else {
            throw new RouteException('Controller must be specified.');
        }
    }
	
    public function setName($name)
    {
        $this->name = trim($name);
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
	
    public function setPattern($pattern)
    {
        $this->pattern = trim($pattern);
        return $this;
    }
    
    public function getPattern()
    {
        return $this->pattern;
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
    
    public function setExtras(array $extras)
    {
        $this->extras = $extras;
        return $this;
    }

    public function getExtras()
    {
        return $this->extras;
    }
    
    public function hasExtras()
    {
        return (bool) !empty($this->extras);
    }
    
    public function isStatic()
    {
        return (bool) !strpos($this->pattern, '{');
    }
}