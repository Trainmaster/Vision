<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\DataStructures\EntityManager\IO;

use Vision\DataStructures\EntityManager\EntityManager;
use Vision\File\Loader\ArrayFileLoader;

/**
 * ArrayIO
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class ArrayIO implements IOInterface
{
    public function __construct(ArrayFileLoader $loader)
    {
        $this->loader = $loader;
    }

    public function import($file, EntityManager $em)
    {
        $array = $this->loader->load($file);

        if ($array) {
            if (isset($array['repositories'])) {
                $em->registerRepositories($array['repositories']);
            }

            return true;
        }

        return false;
    }

    public function export($file, EntityManager $em)
    {
        throw new \Exception ('Not yet implemented.');
    }
}
