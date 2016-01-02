<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Cache;

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
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * @api
     *
     * @param string $key
     * @param mixed $value
     * @param int $expiration
     *
     * @return Storage\StorageInterface
     */
    public function set($key, $value, $expiration = 0)
    {
        return $this->storage->set($key, $value, $expiration);
    }

    /**
     * @api
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->storage->get($key);
    }
}
