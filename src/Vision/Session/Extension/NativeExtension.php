<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Session\Extension;

use Vision\Session\SessionInterface;

/**
 * NativeExtension
 *
 * @author Frank Liepert
 */
class NativeExtension implements ExtensionInterface
{
    /** @type bool $started */
    protected $started = false;
        
    /**
     * @api
     *
     * @throws \RuntimeException
     * 
     * @return bool
     */
    public function start()
    {
        if ($this->started) {
            return true;
        }
        
        if (session_start()) {
            $this->started = true;
            return true;
        } else {
            throw \RuntimeException('Session could not be started.');
        }
    }
    
    /**
     * @api
     * 
     * @param SessionInterface $session 
     * 
     * @return void
     */
    public function load(SessionInterface $session)
    {
        if (!$this->started) {
            $this->start();
        }     
        
        $session->exchangeArray($_SESSION);
    }
    
    /**
     * @api
     * 
     * @param SessionInterface $session 
     * 
     * @return void
     */
    public function save(SessionInterface $session)
    {
        $status = $this->getStatus();
        
        if (isset($status) && $status !== PHP_SESSION_ACTIVE) {
            $this->started = false;
            $this->start();
        } else {
            @session_start();
        }

        $_SESSION = $session->getArrayCopy();
    }

    /**
     * @api
     * 
     * @return bool
     */
    public function isStarted()
    {
        return (bool) $this->started;
    }
    
    /**
     * @api
     * 
     * @return null|int
     */
    public function getStatus()
    {
        if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
            return session_status();
        }
        return null;
    }
    
    /**
     * @api
     * 
     * @return string
     */
    public function getId()
    {
        return session_id();
    }
    
    /**
     * @api
     * 
     * @param bool $deleteOldSession  
     * 
     * @return bool
     */
    public function regenerateId($deleteOldSession = true)
    {
        return session_regenerate_id($deleteOldSession);
    }
}