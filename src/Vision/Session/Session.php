<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Session;

use Vision\DataStructures\ArrayProxyObject;

/**
 * Session
 *
 * @author Frank Liepert
 */
class Session extends ArrayProxyObject
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
    
    public function __toString()
    {
        return serialize($this->getArrayCopy());
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