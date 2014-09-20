<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\File;

use InvalidArgumentException;

/**
 * UploadedFile
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class UploadedFile extends File
{
    /**
     * Constructor
     *
     * @param string $filename
     */
    public function __construct($filename)
    {
        if (!is_uploaded_file($filename)) {
            throw new InvalidArgumentException(sprintf(
                'The file "%s" is not an uploaded file.',
                $filename
            ));
        }

        parent::__construct($filename);
    }
}
