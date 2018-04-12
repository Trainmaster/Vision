<?php
declare(strict_types = 1);

namespace Vision\File;

use finfo;

class File extends \SplFileObject
{
    /**
     * @return string
     */
    public function getMimeType(): string
    {
        $finfo = new finfo(FILEINFO_MIME);
        return $finfo->file(parent::getPathname());
    }
}
