<?php
namespace Vision\DataStructures;

class SuperglobalProxyObject
{
    protected $data = array();
        
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function get($name)
    {
        if (strpos($name, '[]') !== false) {
            $name = str_replace('[]', '', $name);
        }
		$parts = explode('[', $name);
		$value = $this->data;
		foreach ($parts as $part) {
			$part = trim($part, ']');
			if (isset($value[$part])) {
				$value = $value[$part];
			} else {
				return null;
			}
		} 
		return $value;
    }
}