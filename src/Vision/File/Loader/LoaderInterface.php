<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\File\Loader;

/**
 * LoaderInterface
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
interface LoaderInterface
{
    /**
     * @param string $resource 
     */
    public function load($resource);
}