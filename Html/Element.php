<?php
namespace Vision\Html;

class Element 
{
    protected $attributes = array();
    
    protected $content = null;
    
    protected $isVoidElement = false;
    
    protected $tag = null; 
   
    protected $view = null;
    
    public function __construct($tag) 
    {
        $this->setTag($tag);
    }    
        
    public function __toString() 
    {
        if ($this->view === null) {
            $this->view = new \Vision\View\Html\Element($this);
        }
        return $this->view->__toString();
    } 
    
    public function setTag($tag) 
    {       
        $this->tag = (string) $tag;
        return $this;
    }
    
    public function getTag() 
    {
        return $this->tag;
    }
      
    public function setIsVoidElement($isVoidElement) 
    {
        $this->isVoidElement = (bool) $isVoidElement;
        return $this;    
    }
    
    public function isVoidElement() 
    {
        return $this->isVoidElement;    
    }
    
    public function setContent($content) 
    {
        $this->content = (string) $content;
        return $this;
    }
    
    public function getContent() 
    {
        return $this->content;
    }   
    
    public function setAttribute($key, $value) 
    {
        $this->attributes[$key] = $value;
        return $this;
    }
    
    public function setAttributes(array $attributes) 
    {
        foreach($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }
        return $this;
    }
    
    public function getAttribute($key) 
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }
        return null;
    } 
    
    public function getAttributes() 
    {
        return $this->attributes;
    }
    
    public function addClass($class) 
    {
        $class = trim($class);
        if ($this->getAttribute('class') !== null) {
            $class = $this->getAttribute('class').' '.$class;	
        }
        $this->setAttribute('class', $class);
        return $this;
    }
    
    public function removeClass($class) 
    {
        $classAttribute = $this->getAttribute('class');
        $class = str_replace($class, '', $classAttribute);
        $this->setAttribute('class', $class);
        return $this;
    }
}