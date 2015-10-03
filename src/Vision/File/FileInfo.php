<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\File;

class FileInfo extends \SplFileInfo
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
}
