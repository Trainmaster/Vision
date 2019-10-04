<?php

declare(strict_types=1);

namespace Vision\Session\Extension;

use Vision\Session\SessionInterface;
use SessionHandlerInterface;
use RuntimeException;

class NativeExtension implements ExtensionInterface
{
    /**
     * @param SessionHandlerInterface|null $handler
     */
    public function __construct(SessionHandlerInterface $handler = null)
    {
        if (isset($handler)) {
            session_set_save_handler($handler, true);
        }
    }

    /**
     * @param SessionInterface $session
     * @throws RuntimeException
     */
    public function start(SessionInterface $session): void
    {
        if ($this->isActive()) {
            return;
        }

        if (!session_start()) {
            throw new RuntimeException('Session could not be started.');
        }

        $session->exchangeArray($_SESSION);
    }

    /**
     * @param SessionInterface $session
     */
    public function writeClose(SessionInterface $session): void
    {
        $this->start($session);
        $_SESSION = $session->getArrayCopy();
        session_write_close();
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->getStatus() === PHP_SESSION_ACTIVE;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return session_status();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return session_id();
    }

    /**
     * @param bool $deleteOldSession
     * @return bool
     */
    public function regenerateId(bool $deleteOldSession = true): bool
    {
        return session_regenerate_id($deleteOldSession);
    }
}
