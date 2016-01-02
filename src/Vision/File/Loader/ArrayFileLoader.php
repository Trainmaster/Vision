<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\File\Loader;

class ArrayFileLoader extends AbstractFileLoader
{
    /**
     * @api
     *
     * @param string $file
     *
     * @return array
     */
    public function load($file)
    {
        if (!$this->isLoadable($file)) {
            return [];
        }

        $array = include $file;

        if (is_array($array)) {
            return $array;
        }

        return [];
    }
}
