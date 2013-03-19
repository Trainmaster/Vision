<?php
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