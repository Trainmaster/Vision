<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Cache\Storage;

/**
 * StorageInterface
 *
 * @author Frank Liepert
 */
interface StorageInterface
{    
    public function set($key, $value);
    
    public function get($key);
}