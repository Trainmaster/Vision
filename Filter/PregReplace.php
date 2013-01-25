<?php
namespace Vision\Filter;

class PregReplace implements FilterInterface
{
    protected $pattern = null;
    
    protected $replacement = null;
    
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
    *
    * See manual: http://php.net/manual/de/function.preg-replace.php
    *
    */
    public function filter($value) 
    {   
        return preg_replace($this->pattern, $this->replacement, $value);
    }
}