<?php
namespace Vision\Html;

class ElementFactory
{
    protected static $voidElements = array( 'area', 'base', 'br', 'col', 'command', 'embed', 
                                            'hr', 'img', 'input', 'keygen', 'link', 'meta', 
                                            'param', 'source', 'track', 'wbr');

    public static function create($tag) {        
        if (is_string($tag) === false) {
            throw new \Exception('String must be provided');
        }
               
        $tag = trim($tag);
        $tag = strtolower($tag);        
        
        $element = new Element($tag);
        
        if (in_array($tag, self::$voidElements)) {
            $element->setIsVoidElement(true);
        }
        
        return $element;    
    }
}