<?php
namespace Vision\Validator;

class PregMatch extends AbstractValidator
{   
    const NO_MATCH_FOUND = 'No match was found.';
    
    protected $pattern;

    public function __construct(array $options = array())
    {
        if (isset($options['pattern'])) {
            $this->setPattern($options['pattern']);
        }
    }
    
    public function setPattern($pattern)
    {
        $this->pattern = (string) $pattern;
        return $this;
    }
    
    public function isValid($value)
    {
        $result = preg_match($this->pattern, $value);
        $result = (bool) $result;
        
        if ($result) {
            return true;
        }
        
        $this->addError(self::NO_MATCH_FOUND);
        
        return false;
    }
}