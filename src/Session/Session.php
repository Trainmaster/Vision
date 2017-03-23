<?php
declare(strict_types=1);

namespace Vision\Session;

use Vision\DataStructures\Arrays\ArrayObject;
use Vision\Session\Extension\ExtensionInterface;

class Session extends ArrayObject implements SessionInterface
{
    /** @var null|Extension\ExtensionInterface $extension */
    private $extension;

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

    public function __toString(): string
    {
        return serialize($this->getArrayCopy());
    }

    public function getExtension(): ExtensionInterface
    {
        return $this->extension;
    }

    public function clear()
    {
        $this->exchangeArray([]);
    }

    public function start()
    {
        $this->extension->start();
    }

    /**
     * @see Extension\ExtensionInterface
     */
    public function getStatus(): int
    {
        return $this->extension->getStatus();
    }

    /**
     * @see Extension\ExtensionInterface
     */
    public function getId(): string
    {
        return $this->extension->getId();
    }

    /**
     * @param bool $deleteOldSession
     *
     * @see Extension\ExtensionInterface
     */
    public function regenerateId($deleteOldSession = true): bool
    {
        return $this->extension->regenerateId($deleteOldSession);
    }
}
