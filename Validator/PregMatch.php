<?php
namespace Vision\Validator;

class PregMatch extends ValidatorAbstract
{	
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
        if ($result === false) {
            $this->setMessage('PREG_MATCH', 'Value does not match RegExp.');
            return false;
        }
        return true;
    }
}