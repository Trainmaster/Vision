<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\File\Loader;

abstract class AbstractFileLoader implements LoaderInterface
{
    /**
     * @param string $file
     *
     * @return bool
     */
    public function isLoadable($file)
    {
        return (is_file($file) && is_readable($file));
    }
}
