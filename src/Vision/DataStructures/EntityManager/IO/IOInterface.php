<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\DataStructures\EntityManager\IO;

use Vision\DataStructures\EntityManager\EntityManager;

/**
 * IOInterface
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
interface IOInterface
{
    /**
     * @api
     *
     * @param string $file
     * @param EntityManager $em
     */
    public function import($file, EntityManager $em);

    /**
     * @api
     *
     * @param string $file
     * @param EntityManager $em
     */
    public function export($file, EntityManager $em);
}
