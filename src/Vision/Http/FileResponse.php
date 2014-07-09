<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Http;

use Vision\File\File;

/**
 * FileResponse
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class FileResponse extends Response
{
    /** @type string $file */
    protected $file;

    /**
     * Constructor
     *
     * @param \Vision\File\File|string $file
     */
    public function __construct($file)
    {
        if ($file instanceof File) {
            $this->file = $file;
        } else {
            $this->file = new File($file, 'rb');
        }
    }

    /**
     * @api
     *
     * @return void
     */
    public function send()
    {
        $this->addHeader('Content-Length', $this->file->getSize());

        $this->sendStatusLine()
             ->sendHeaders();

        $this->file->fpassthru();
        exit;
    }
}
