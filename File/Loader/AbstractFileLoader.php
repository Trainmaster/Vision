<?php 
namespace Vision\File\Loader;

abstract class AbstractFileLoader implements LoaderInterface
{     
    public function isLoadable($file)
    {	
        if (is_file($file) && is_readable($file)) {
            return true;
        } 	
        return false;
    }
}