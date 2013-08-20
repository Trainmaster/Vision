<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Filter;

/**
 * PregReplace
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class PregReplace implements FilterInterface
{
    /**
     * @type null|string
     */    
    protected $pattern = null;
    
    /**
     * @type null|mixed
     */
    protected $replacement = null;
    
    /**
     * @param array $options  
     * 
     * @return void
     */
    public function __construct(array $options = array())
    {
        if (isset($options['pattern'])) {
            $this->pattern = $options['pattern'];
        }
        
        if (isset($options['replacement'])) {
            $this->replacement = $options['replacement'];
        }
    }
    
    /**
    * @link http://php.net/manual/de/function.preg-replace.php
    *
    * @param mixed $value
    */
    public function filter($value) 
    {   
        return preg_replace($this->pattern, $this->replacement, $value);
    }
}