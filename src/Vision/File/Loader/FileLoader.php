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
 * FileLoader
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class FileLoader extends AbstractFileLoader
{     
    /**
     * @api
     * 
     * @param string $file 
     * 
     * @return mixed
     */
    public function load($file)
    {   
        if ($this->isLoadable($file)) {
            return include $file;
        }
        
        return false;
    }
}