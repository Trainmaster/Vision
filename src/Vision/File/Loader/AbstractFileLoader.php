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
 * AbstractFileLoader
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
abstract class AbstractFileLoader implements LoaderInterface
{     
    /**
     * @api
     * 
     * @param string $file 
     * 
     * @return bool
     */
    public function isLoadable($file)
    {   
        if (is_file($file) && is_readable($file)) {
            return true;
        }
        
        return false;
    }
}