<?php
declare(strict_types=1);

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
        register_shutdown_function([$this, '__destruct']);
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
        return $this->exchangeArray([]);
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
