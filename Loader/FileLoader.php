<?php 
namespace Vision\Loader;

class FileLoaderException extends \Exception {}

class FileLoader {
	
	public function load($resource) {
		if ($this->validate($resource)) {
			include $resource;
			return true;
		}
		return false;
	}
            
	protected function validate($resource) {	
		if (is_file($resource) === false) {
			throw new FileLoaderException(sprintf('"%s" does not exist.', $resource));
		} 
		if (is_readable($resource) === false){
			throw new FileLoaderException(sprintf('"%s" is not readable.', $resource));
		}		
		return true;
	}
}