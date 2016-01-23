<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
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
