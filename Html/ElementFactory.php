<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Html;

use InvalidArgumentException;

/**
 * @author Frank Liepert
 */
class ElementFactory
{
    /** @type array $voidElements */
    protected static $voidElements = array( 'area', 'base', 'br', 'col', 'command', 'embed', 
                                            'hr', 'img', 'input', 'keygen', 'link', 'meta', 
                                            'param', 'source', 'track', 'wbr');
    /**
     * @param string $tag 
     * 
     * @throws InvalidArgumentException
     *
     * @return \Vision\Html\Element $element
     */
    public static function create($tag)
    {
        if (is_string($tag) === false) {
            throw new InvalidArgumentException('String must be provided.');
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