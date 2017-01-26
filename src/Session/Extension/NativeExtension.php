<?php
declare(strict_types=1);

namespace Vision\Session\Extension;

use Vision\Session\SessionInterface;

use SessionHandlerInterface;

class NativeExtension implements ExtensionInterface
{
    /** @var bool $started */
    protected $started = false;

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
            throw new \RuntimeException('Session could not be started.');
        }
    }

    /**
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
     * @return bool
     */
    public function isStarted()
    {
        return (bool) $this->started;
    }

    /**
     * @return null|int
     */
    public function getStatus()
    {
        return session_status();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return session_id();
    }

    /**
     * @param bool $deleteOldSession
     *
     * @return bool
     */
    public function regenerateId($deleteOldSession = true)
    {
        return session_regenerate_id($deleteOldSession);
    }
}
