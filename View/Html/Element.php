<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\View\Html;

use Vision\Html\Element as HtmlElement;

/**
 * Element
 *
 * @author Frank Liepert
 */ 
class Element 
{
    /** @type HtmlElement $element */
    protected $element;
    
    /**
     * 
     * 
     * @param HtmlElement $element 
     * 
     * @return void
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
        $html = $this->renderStartTag();        
        
        if ($this->element->isVoid()) {
            return $html;            
        }   
        
        $html .= $this->element->getContent() 
              .  $this->renderEndTag();  
                  
        return $html;
    }   
    
    /**
     * Render start tag
     * 
     * @return string
     */
    public function renderStartTag()
    {
        $html = '<%s%s%s>';
        $tag = $this->element->getTag();
        
        if (empty($tag)) {
            return '';
        }        
        
        $attributes = $this->renderAttributes();
        $slash = '';
        
        if ($this->element->isVoid()) {
            $slash = ' /';
        }  
        
        return sprintf($html, $tag, $attributes, $slash);
    }
    
    /**
     * Render end tag
     * 
     * @return string
     */
    public function renderEndTag()
    {
        $html = '</%s>';
        $tag = $this->element->getTag();
        
        if (empty($tag)) {
            return '';
        }   
        
        return sprintf($html, $tag);
    }
    
    /**
     * Apply htmlspecialchars()
     * 
     * @param mixed $value 
     * 
     * @return string
     */
    protected function clean($value)
    {
        if (is_string($value) || is_int($value)) {
            return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);            
        }
        return null;
    }
    
    /**
     * Render attributes
     * 
     * @return string
     */
    protected function renderAttributes()
    {
        $html = '';
        $attributes = $this->element->getAttributes();
        
        if (empty($attributes)) {
            return $html;
        }
        
        foreach ($attributes as $key => $value) {
            if (strlen($key) < 1) {
                break;
            }
            
            if ($value === null) {
                $html .= ' ' . $this->clean($key);
            } else {
                $html .= ' ' . $this->clean($key) . '="' . $this->clean($value). '"';
            }
        }
        
        return $html;
    }       
}