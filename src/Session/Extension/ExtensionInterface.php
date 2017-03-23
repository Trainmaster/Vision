<?php
declare(strict_types=1);

namespace Vision\Session\Extension;

use Vision\Session\SessionInterface;

interface ExtensionInterface
{
    public function start();

    public function load(SessionInterface $session);

    public function save(SessionInterface $session);

    public function getStatus(): int;

    public function getId(): string;

    public function regenerateId($deleteOldSession = true): bool;
}
