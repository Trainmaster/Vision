<?php
namespace Vision\Session;

use Vision\Session\Extension\NativeExtension;
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
    
    public function regenerateId($deleteOldSession = false)
    {
        return $this->extension->regenerateId($deleteOldSession);
    }
    
    public function init()
    {
        if (empty($_SESSION['security_token'])) {
            $_SESSION['start'] = time();
            $_SESSION['end'] = time() + 3600;
            $_SESSION['client_group'] = '1';
            $_SESSION['lang'] = 'de';
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            }
            $_SESSION['security_token'] = hash('sha512', uniqid(mt_rand(), true));
        }		
        if ($this->validate() === false) {
            session_unset();
            session_destroy();
        } else {	
            $difference = $_SESSION['end'] - time();
            if ($difference > 0) {
                $_SESSION['end'] = time() + 3600;
            }	
        }        
    }
    
    private function validate() {	
        if ($_SESSION['end'] < time()) {
            return false;
        }		
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            if ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) { 
                return false;
            }	
        } else {
            return false;
        }
        return true;
	}
    
    public function setNamespace($namespace) {
		$this->namespace = (string) $namespace;
		return $this;
	}
	
    public function getNamespace() {
        return $this->namespace;
    }
    
    public function load($key) {
        if ($this->getNamespace()) {			
            if (isset($_SESSION[$this->getNamespace()][$key])) {
                return $_SESSION[$this->getNamespace()][$key];
            }
        } elseif (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
	}
    
    public function save($key, $value)
    {
        $_SESSION[$key] = $value;
        return $this;
	}
    
    public function delete($key)
    {
        if ($this->getNamespace()) {
            unset($_SESSION[$this->getNamespace()][$key]);
        } else {
            unset($_SESSION[$key]);
        }
    }
}