<?php
declare(strict_types=1);

namespace Vision\Session;

use Vision\DataStructures\Arrays\ArrayObject;

class Session extends ArrayObject implements SessionInterface
{
    /** @var Extension\ExtensionInterface $extension */
    private $extension;

    /**
     * @param Extension\ExtensionInterface $extension
     */
    public function __construct(Extension\ExtensionInterface $extension)
    {
        parent::__construct();
        $this->extension = $extension;
        $this->extension->start($this);
        register_shutdown_function([$this, 'writeClose']);
    }

    public function __toString(): string
    {
        return serialize($this->getArrayCopy());
    }

    public function writeClose()
    {
        $this->extension->writeClose($this);
    }

    public function clear()
    {
        $this->exchangeArray([]);
    }

    public function getStatus(): int
    {
        return $this->extension->getStatus();
    }

    public function getId(): string
    {
        return $this->extension->getId();
    }

    public function regenerateId(bool $deleteOldSession = true): bool
    {
        return $this->extension->regenerateId($deleteOldSession);
    }
}
