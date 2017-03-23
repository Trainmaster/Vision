<?php
declare(strict_types=1);

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
    public function start()
    {
        if ($this->started && $this->isActive()) {
            return;
        }

        if (session_start()) {
            $this->started = true;
            return;
        }

        throw new RuntimeException('Session could not be started.');
    }

    public function load(SessionInterface $session)
    {
        $this->start();
        $session->exchangeArray($_SESSION);
    }

    public function save(SessionInterface $session)
    {
        $this->start();
        $_SESSION = $session->getArrayCopy();
    }

    public function isStarted(): bool
    {
        return (bool) $this->started;
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

    public function regenerateId($deleteOldSession = true): bool
    {
        return session_regenerate_id($deleteOldSession);
    }
}
