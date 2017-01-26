<?php
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
    public function exists();

    /**
     * @return void
     */
    public function clear();
}
