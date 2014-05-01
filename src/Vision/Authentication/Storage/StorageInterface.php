<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
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
     * @api
     *
     * @return void
     */
    public function save($data);

    /**
     * @api
     *
     * @return mixed
     */
    public function load();

    /**
     * @api
     *
     * @return bool
     */
    public function exists();

    /**
     * @api
     *
     * @return void
     */
    public function clear();
}
