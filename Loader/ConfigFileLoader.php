<?php 
namespace Vision\Loader;

use Vision\Loader\FileLoader;

class ConfigFileLoaderException extends \Exception {}

class ConfigFileLoader extends FileLoader 
{
    public function load($resource, $type = null)
    {
        if (parent::validate($resource)) {
            return include $resource;
        } 
        return false;
    }
}