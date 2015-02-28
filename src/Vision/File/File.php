<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\File;

use finfo;

/**
 * File
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class File extends \SplFileObject
{
    /**
     * @api
     *
     * @todo Possible candidate for trait
     *
     * @return bool
     */
    public function isLoadable()
    {
        return parent::isFile() && parent::isReadable();
    }

    /**
     * @api
     *
     * @return string|false
     */
    public function getMimeType()
    {
        $finfo = new finfo(FILEINFO_MIME);
        return $finfo->file(parent::getPathname());
    }
}
