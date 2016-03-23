<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\File;

use finfo;

class File extends \SplFileObject
{
    /**
     * @return string
     */
    public function getMimeType()
    {
        $finfo = new finfo(FILEINFO_MIME);
        return $finfo->file(parent::getPathname());
    }
}
