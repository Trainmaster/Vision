<?php
namespace Vision\Session;

use ArrayObject;

class Session extends ArrayObject
{    
    protected $extension = null;
    
    public function __construct($extension) 
    {		
        register_shutdown_function(array($this, '__destruct'));
        $this->setExtension($extension);
        $this->extension->start();
        $this->extension->load($this);
    }
    
    public function __destruct()    
    {
        $this->extension->save($this);
    }

    public function clear()
    {
        $this->exchangeArray(array());
    }
    
    public function start()
    {
        return $this->getExtension()->start();
    }
    
    public function setExtension($extension)
    {
        $this->extension = $extension;
        return $this;
    }
    
    public function getExtension()
    {
        return $this->extension;
    }
    
    public function getStatus()
    {
        return $this->extension->getStatus();
    }
    
    public function getId()
    {
        return $this->extension->getId();
    }
    
    public function regenerateId($deleteOldSession = true)
    {
        return $this->extension->regenerateId($deleteOldSession);
    }
}