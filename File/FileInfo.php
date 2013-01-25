<?php
namespace Vision\File;

use SplFileInfo;
use RuntimeException;

class FileInfo extends SplFileInfo 
{
    public function isLoadable() 
    {                
        if ($this->isFile() === false && $this->isReadable() === false) {
            return false;
        }        
        return true;
    }
}