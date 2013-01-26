<?php
namespace Vision\View\Html;

use Vision\Html\Element as HtmlElement;

class Element 
{
    /**
    * HtmlElement
    *
    * @var Vision\Html\Element
    */
    private $element;
    
    /**
    * Object constructor
    *
    * @param \Vision\Html\Element $element
    */
    public function __construct(HtmlElement $element)
    {
        $this->element = $element;
    }
    
    /**
    * String representation of element
    *
    * @return string
    */
    public function __toString()
    {
        $html = $this->renderStartTag()
              . $this->element->getContent()
              . $this->renderEndTag();
        return $html;
    }
    
    /**
    * Apply htmlspecialchars()
    *
    * @return string
    */
	protected function clean($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }
    
    /**
    * Render start tag
    *
    * @return string
    */  
    private function renderStartTag()
    {
        $html = '<%s%s%s>';
        $tag = $this->element->getTag();
        $attributes = $this->renderAttributes();
        $slash = null;
        if ($this->element->isVoidElement()) {
            $slash = '/';
        }    
        return sprintf($html, $tag, $attributes, $slash);
    }
    
    /**
    * Render end tag
    *
    * @return string
    */   
    private function renderEndTag()
    {
        $html = '';
        if ($this->element->isVoidElement()) {
            return $html;
        }
        $html .= '</%s>';
        $tag = $this->element->getTag();
        return sprintf ($html, $tag);
    }
    
    /**
    * Render attributes
    *
    * @return string
    */
    private function renderAttributes()
    {
        $html = '';
        $attributes = $this->element->getAttributes();
        if (!empty($attributes)) {       
            foreach ($attributes as $key => $value) {
                if ($value === null) {
                    $html .= ' '.$this->clean($key);
                } else {
                    $html .= ' '.$this->clean($key).'="'.$this->clean($value).'"';
                }
            }
        }
        return $html;
    }       
}