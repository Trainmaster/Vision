<?php
namespace Vision\Html;

use Vision\View\Html\Element as HtmlElementView;

class Element 
{
    protected $attributes = array();
    
    protected $content = null;
    
    protected $isVoid = false;
    
    protected $tag = null;
    
    protected $view = null;
    
    public function __construct($tag) 
    {
        $this->setTag($tag);
    } 
    
    public function __toString() 
    {
        $this->initView();
        return $this->view->__toString();
    }
    
    public function renderStartTag()
    {
        $this->initView();
        return $this->view->renderStartTag();
    }
    
    public function renderEndTag()
    {
        $this->initView();
        return $this->view->renderEndTag();
    }
    
    public function initView()
    {
        if ($this->view === null) {
            $this->view = new HtmlElementView($this);
        }
        return $this;
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
    
    public function setVoid($isVoid) 
    {
        $this->isVoid = (bool) $isVoid;
        return $this;    
    }
    
    public function isVoid() 
    {
        return $this->isVoid;    
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
    
    public function setAttribute($key, $value = null) 
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
    
    public function removeAttribute($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            unset($this->attributes[$key]);
            return true;
        }
        return false;
    }
    
    public function setId($id)
    {
        $id = str_replace('_', '-', $id);
        $this->setAttribute('id', $id);
        return $this;
    }
    
    public function getId()
    {
        return $this->getAttribute('id');
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