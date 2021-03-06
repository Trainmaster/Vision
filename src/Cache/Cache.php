<?php

declare(strict_types=1);

namespace Vision\Cache;

use Vision\Cache\Storage\StorageInterface;

class Cache implements CacheInterface
{
    /** @var Storage\StorageInterface $storage */
    protected $storage;

    /**
     * @param Storage\StorageInterface $storage
     */
    public function __construct(Storage\StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return Storage\StorageInterface
     */
    public function getStorage(): StorageInterface
    {
        return $this->storage;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $expiration
     *
     * @return Storage\StorageInterface
     */
    public function set($key, $value, $expiration = 0): StorageInterface
    {
        return $this->storage->set($key, $value, $expiration);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->storage->get($key);
    }
}
