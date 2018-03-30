<?php
declare(strict_types = 1);

namespace Vision\Session\Extension;

use Vision\Session\SessionInterface;

interface ExtensionInterface
{
    public function start(SessionInterface $session): void;

    public function writeClose(SessionInterface $session);

    public function getStatus(): int;

    public function getId(): string;

    public function regenerateId(bool $deleteOldSession = true): bool;
}
