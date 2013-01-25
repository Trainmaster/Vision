<?php
namespace Vision\Controller;

abstract class Controller 
{   
    public $request = null;
	
	public $view = null;
	
	protected $container = null;
	
	protected $language = 'de';
                
	public function setContainer($container) 
    {
		$this->container = $container;
		return $this;
	}
	
	public function getContainer() 
    {
		return $this->container;
	}
	
	public function get($id) 
    {
		return $this->container->get($id);
	}
	
	public function setLanguage($language) 
    {
		$this->language = (string) $language;
		return $this;
	}
    
    public function getLanguage() 
    {
        return $this->language;
    }
}