<?php
declare(strict_types=1);

namespace Vision\Session;

interface SessionInterface
{
    public function clear();

    public function start();

    public function getStatus(): int;

    public function getId(): string;

    public function regenerateId($deleteOldSession = true): bool;

    public function exchangeArray(array $data): array;

    public function getArrayCopy(): array;
}
