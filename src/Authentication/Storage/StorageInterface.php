<?php
declare(strict_types = 1);

namespace Vision\Authentication\Storage;

interface StorageInterface
{
    /**
     * @param $data
     *
     * @return void
     */
    public function save($data);

    /**
     * @return mixed
     */
    public function load();

    /**
     * @return bool
     */
    public function exists(): bool;

    /**
     * @return void
     */
    public function clear(): void;
}
