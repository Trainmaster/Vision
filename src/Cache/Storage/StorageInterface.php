<?php
namespace Vision\Cache\Storage;

interface StorageInterface
{
    public function set($key, $value, $expiration);

    public function get($key);
}
