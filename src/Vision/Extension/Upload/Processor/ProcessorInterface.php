<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Extension\Upload\Processor;

use Vision\File\UploadedFile;

/**
 * ProcessorInterface
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
interface ProcessorInterface
{
    /**
     * @api
     *
     * @param UploadedFile $file
     * @param string $dest
     */
    public function process(UploadedFile $file, $dest);

    /**
     * @api
     *
     * @return bool
     */
    public function isResponsibleFor(UploadedFile $file);
}
