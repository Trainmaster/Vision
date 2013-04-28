<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\DataStructures;

/**
 * SuperglobalProxyObject
 *
 * @author Frank Liepert
 */
class SuperglobalProxyObject extends ArrayProxyObject
{
    /**
     * Retrieve array value by html array notation
     * 
     * Example: $this->getValueByName(foo[bar][baz]) returns
     *          the value of $this->data[$foo][$bar][$baz] or NULL.
     * 
     * @param string $name 
     * 
     * @return mixed
     */
    public function getValueByName($name)
    {
        print $name;
        print_r ($this->data);
        if (strpos($name, '[]') !== false) {
            $name = str_replace('[]', '', $name);
        }
        
        $parts = explode('[', $name);
        $value = $this->data;
        
        foreach ($parts as $part) {
            $part = rtrim($part, ']');
            if (isset($value[$part])) {
                $value = $value[$part];
            } else {
                return null;
            }
        }
        
        return $value;
    }
}