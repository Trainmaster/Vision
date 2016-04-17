<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\File\Loader;

class ArrayFileLoader implements LoaderInterface
{
    /**
     * @param string $file
     *
     * @return array
     */
    public function load($file)
    {
        if (!is_readable($file)) {
            return [];
        }

        $data = include $file;

        return is_array($data) ? $data : [];
    }
}
