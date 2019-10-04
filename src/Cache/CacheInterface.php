<?php

declare(strict_types=1);

namespace Vision\Cache;

use Vision\Cache\Storage\StorageInterface;

interface CacheInterface
{
    public function getStorage(): StorageInterface;

    public function set($key, $value, $expiration = 0): StorageInterface;

    public function get($key);
}
