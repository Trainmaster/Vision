<?php
declare(strict_types = 1);

namespace Vision\Cache\Storage;

interface StorageInterface
{
    public function set($key, $value, $expiration);

    public function get($key);
}
