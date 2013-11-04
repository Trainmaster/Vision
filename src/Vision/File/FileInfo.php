<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\File;

use SplFileInfo;

/**
 * FileInfo
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class FileInfo extends SplFileInfo
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
        if ($this->isFile() && $this->isReadable()) {
            return true;
        }
        return false;
    }

    /**
     * @api
     *
     * @return bool
     */
    public function isUploadedFile()
    {
        return is_uploaded_file($this);
    }
}
