<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Html;

use Vision\View\Html\Element as HtmlElementView;

/**
 * @author Frank Liepert
 */
class Element 
{
    /**
     * @type array $attributes
     */
    protected $attributes = array();
    
    /**
     * @type null|string $content
     */
    protected $content = null;
    
    /**
     * @type bool $isVoid
     */
    protected $isVoid = false;
    
    /**
     * @type null|string $tag
     */
    protected $tag = null;
    
    /**
     * @type null|HtmlElementView $view
     */
    protected $view = null;
    
    /**
     * @param string $tag 
     * 
     * @return void
     */
    public function __construct($tag) 
    {
        $this->setTag($tag);
    } 
    
    /**
     * @return string
     */
    public function __toString() 
    {
        $this->initView();
        return $this->view->__toString();
    }
    
    /**
     * @return string
     */
    public function renderStartTag()
    {
        $this->initView();
        return $this->view->renderStartTag();
    }
    
    /**
     * @return string
     */
    public function renderEndTag()
    {
        $this->initView();
        return $this->view->renderEndTag();
    }    
    
    /**
     * @return void
     */
    public function initView()
    {
        if ($this->view === null) {
            $this->view = new HtmlElementView($this);
        }
        return $this;
    }
    
    /**
     * @param string $tag 
     * 
     * @return Element Provides a fluent interface.
     */
    public function setTag($tag) 
    {       
        $this->tag = (string) $tag;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getTag() 
    {
        return $this->tag;
    }
    
    /**
     * @param bool $isVoid 
     * 
     * @return Element Provides a fluent interface.
     */
    public function setVoid($isVoid) 
    {
        $this->isVoid = (bool) $isVoid;
        return $this;    
    }
    
    /**
     * @return bool
     */
    public function isVoid() 
    {
        return $this->isVoid;    
    }
    
    /**
     * @param string $content 
     * 
     * @return Element Provides a fluent interface.
     */
    public function setContent($content) 
    {
        $this->content = (string) $content;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getContent() 
    {
        return $this->content;
    }

    /**
     * @param string $key 
     * @param string $value  
     * 
     * @return Element Provides a fluent interface.
     */
    public function setAttribute($key, $value = null) 
    {
        $this->attributes[$key] = $value;
        return $this;
    }
    
    /**
     * @param array $attributes 
     * 
     * @return Element Provides a fluent interface.
     */
    public function setAttributes(array $attributes) 
    {
        foreach($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }
        return $this;
    }
    
    /**
     * @param string $key 
     * 
     * @return null|Element
     */
    public function getAttribute($key) 
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }
        return null;
    }
    
    /**
     * @return array
     */
    public function getAttributes() 
    {
        return $this->attributes;
    }
    
    /**
     * @param string $key 
     * 
     * @return bool
     */
    public function removeAttribute($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            unset($this->attributes[$key]);
            return true;
        }
        return false;
    }
    
    /**
     * @param string $id 
     * 
     * @return Element Provides a fluent interface.
     */
    public function setId($id)
    {
        $id = str_replace('_', '-', $id);
        $this->setAttribute('id', $id);
        return $this;
    }
    
    /**
     * @return string
     */
    public function getId()
    {
        return $this->getAttribute('id');
    }
    
    /**
     * @param string $class 
     * 
     * @return Element Provides a fluent interface.
     */
    public function addClass($class) 
    {
        $attribute = $this->getAttribute('class');
        if ($attribute !== null) {
            $class = $attribute . ' ' . $class;   
        }
        $this->setAttribute('class', $class);
        return $this;
    }
    
    /**
     * @param string $class 
     * 
     * @return Element Provides a fluent interface.
     */
    public function removeClass($class) 
    {
        $attribute = $this->getAttribute('class');
        $class = str_replace($class, '', $attribute);
        $this->setAttribute('class', $class);
        return $this;
    }
}