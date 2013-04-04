<?php
namespace Vision\Html;

use InvalidArgumentException;

class ElementFactory
{
    protected static $voidElements = array( 'area', 'base', 'br', 'col', 'command', 'embed', 
                                            'hr', 'img', 'input', 'keygen', 'link', 'meta', 
                                            'param', 'source', 'track', 'wbr');

    public static function create($tag)
    {
        if (is_string($tag) === false) {
            throw new InvalidArgumentException('String must be provided');
        }
               
        $tag = trim($tag);
        $tag = strtolower($tag);        
        
        $element = new Element($tag);
        
        if (in_array($tag, self::$voidElements)) {
            $element->setVoid(true);
        }
        
        return $element;    
    }
}