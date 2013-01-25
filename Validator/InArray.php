<?php
namespace Vision\Validator;

class InArray extends ValidatorAbstract 
{	
    protected $haystack = array();

    protected $strict = false;

    public function __construct(array $options) 
    {
        if (isset($options['haystack'])) {
            $this->setHaystack($options['haystack']);
        }
        if (isset($options['strict'])) {
            $this->setStrict($options['strict']);
        }
    }

    public function setHaystack(array $haystack) 
    {
        $this->haystack = $haystack;
        return $this;
    }

    public function setStrict($strict) 
    {
        $this->strict = (bool) $strict;
        return $this;
    }

    public function isValid($value) 
    {           
        if ($value === null) {
            return true;
        }

        if (is_array($value)) {            
            $result = array_diff($value, $this->haystack);
            if (empty($result)) {
            return true;
            }
        }
        
        if (in_array($value, $this->haystack, $this->strict)) {
            return true;
        }
        
        $this->setMessage('IN_ARRAY', 'Value not found in array.');
        return false;
    }
}