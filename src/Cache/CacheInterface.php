<?php
declare(strict_types=1);

namespace Vision\Cache;

interface CacheInterface
{
    public function getStorage();

    public function set($key, $value, $expiration = 0);

    public function get($key);
}
