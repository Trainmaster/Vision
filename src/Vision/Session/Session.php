<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Session;

use Vision\DataStructures\Arrays\ArrayObject;

class Session extends ArrayObject implements SessionInterface
{
    /** @var null|Extension\ExtensionInterface $extension */
    protected $extension;

    /**
     * @param Extension\ExtensionInterface $extension
     */
    public function __construct(Extension\ExtensionInterface $extension)
    {
        register_shutdown_function(array($this, '__destruct'));
        $this->extension = $extension;
        $this->extension->start();
        $this->extension->load($this);
    }

    public function __destruct()
    {
        $this->extension->save($this);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return serialize($this->getArrayCopy());
    }

    /**
     * @api
     *
     * @return Extension\ExtensionInterface $extension
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return array
     */
    public function clear()
    {
        return $this->exchangeArray(array());
    }

    /**
     * @see Extension\ExtensionInterface
     */
    public function start()
    {
        return $this->extension->start();
    }

    /**
     * @see Extension\ExtensionInterface
     */
    public function getStatus()
    {
        return $this->extension->getStatus();
    }

    /**
     * @see Extension\ExtensionInterface
     */
    public function getId()
    {
        return $this->extension->getId();
    }

    /**
     * @param bool $deleteOldSession
     *
     * @see Extension\ExtensionInterface
     */
    public function regenerateId($deleteOldSession = true)
    {
        return $this->extension->regenerateId($deleteOldSession);
    }
}
