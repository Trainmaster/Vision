<?php
namespace Vision\Session\Extension;

class NativeExtension 
{
    protected $started = false;
    
    public function __construct()
    {
    }
    
    public function start()
    {
        if ($this->started === true) {
            return true;
        }
        
        if (session_start()) {
            $this->started = true;
		} else {
            throw \Exception('Session could not be started.');
        }
    }
    
    public function load($session)
    {
        if ($this->started === false) {
            $this->start();
        }        
        $session->exchangeArray($_SESSION);
        return;
    }
    
    public function save($session)
    {
        // Hackish workaround for session_status() of PHP 5.4
        @session_start();
        return $_SESSION = $session->getArrayCopy();
    }

    public function isStarted()
    {
        return (bool) $this->started;
    }
    
    public function getStatus()
    {
        return session_status();
    }
    
    public function getId()
    {
        return session_id();
    }
    
    public function regenerateId($deleteOldSession)
    {
        return session_regenerate_id($deleteOldSession);
    }
}