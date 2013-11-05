<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Authentication\Storage;

/**
 * StorageInterface
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
interface StorageInterface
{
    /**
     * @return void
     */
    public function save($data);

    /**
     * @return array
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
