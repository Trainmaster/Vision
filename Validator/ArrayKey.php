<?php
namespace Vision\Validator;

class ArrayKey extends ValidatorAbstract 
{
	protected $search = array();
	
	protected $strict = false;
	
	public function __construct(array $options) 
    {
		if (isset($options['search'])) {
			$this->setSearch($options['search']);
		}
	}
    
    public function setSearch(array $search)
    {
        $this->search = $search;
        return $this;
    }
	
	public function isValid($value) 
    {
		if (isset($this->search[$value]) || array_key_exists($value, $this->search)) {
			return true;
		}
		$this->setMessage('IN_ARRAY', 'Value not found in array.');
		return false;
	}
}