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
        return;
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
        // Hackish workaround for session_status() as of PHP 5.4
        @session_start();
        return $_SESSION = $session->getArrayCopy();
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
     * @return int
     */
    public function getStatus()
    {
        return session_status();
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