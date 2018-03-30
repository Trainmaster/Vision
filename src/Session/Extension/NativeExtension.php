<?php
declare(strict_types = 1);

namespace Vision\Session\Extension;

use Vision\Session\SessionInterface;

use SessionHandlerInterface;
use RuntimeException;

class NativeExtension implements ExtensionInterface
{
    private $started = false;

    public function __construct(SessionHandlerInterface $handler = null)
    {
        if (isset($handler)) {
            session_set_save_handler($handler, true);
        }
    }

    /**
     * @throws RuntimeException
     */
    public function start(SessionInterface $session): void
    {
        if ($this->started && $this->isActive()) {
            return;
        }

        if (!session_start()) {
            throw new RuntimeException('Session could not be started.');
        }

        $session->exchangeArray($_SESSION);

        $this->started = true;
    }

    public function writeClose(SessionInterface $session): void
    {
        $this->start($session);
        $_SESSION = $session->getArrayCopy();
        session_write_close();
    }

    public function isStarted(): bool
    {
        return $this->started;
    }

    public function isActive(): bool
    {
        return $this->getStatus() === PHP_SESSION_ACTIVE;
    }

    public function getStatus(): int
    {
        return session_status();
    }

    public function getId(): string
    {
        return session_id();
    }

    public function regenerateId(bool $deleteOldSession = true): bool
    {
        return session_regenerate_id($deleteOldSession);
    }
}
