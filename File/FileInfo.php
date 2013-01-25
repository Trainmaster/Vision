<?php
namespace Vision\File;

use SplFileInfo;

class FileInfo extends SplFileInfo 
{
    public function isLoadable() 
    {                
        if ($this->isFile() && $this->isReadable()) {
            return true;
        }                
        return false;
    }
}