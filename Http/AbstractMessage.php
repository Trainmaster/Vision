<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Http;

use InvalidArgumentException;

/**
 * AbstractMessage
 *
 * @author Frank Liepert
 */
abstract class AbstractMessage 
{
    const VERSION_10 = '1.0';
    
    const VERSION_11 = '1.1';
    
    protected $version = self::VERSION_11;
    
    public function setVersion($version)
    {
        if ($version != self::VERSION_10 || $version != self::VERSION_11) {
            throw new InvalidArgumentException(
                'Not valid or not supported HTTP version: ' . $version
            );
        }
        $this->version = $version;
        return $this;
    }
    
    public function getVersion()
    {
        return $this->version;
    }
}