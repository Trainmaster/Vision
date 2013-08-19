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
 * ArrayFileLoader
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class ArrayFileLoader extends AbstractFileLoader
{     
    /**
     * @api
     * 
     * @param string $file 
     * 
     * @return array|bool
     */
    public function load($file)
    {   
        if ($this->isLoadable($file)) {
            $array = include $file;
            if (is_array($array)) {
                return $array;
            }
        }
        
        return false;
    }
}