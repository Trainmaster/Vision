<?php
namespace Vision\DependencyInjection;

use Vision\DependencyInjection\ContainerDefinition;

class ContainerConfig {
	
	protected $parameters = array();
	
	protected $definitions = array();
	
	protected $resources = array();
    	
	public function addParameter($key, $value) {
		$this->parameters[$key] = $value;
		return $this;
	}
	
	public function getParameters() {
		return $this->parameters;
	}
	
	public function addDefinition($id, $class) {	
		return $this->definitions[$id] = new Definition($class);
	}	
	
	public function getDefinitions() {
		return $this->definitions;
	}
	
	public function addResource($resource) {	
		$this->resources[] = (string) $resource;
		return $this;
	}	
	
	public function getResources() {
		return $this->resources;
	}
}