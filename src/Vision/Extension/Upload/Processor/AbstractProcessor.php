<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Extension\Upload\Processor;

use Vision\File\File;
use Vision\File\UploadedFile;

/**
 * AbstractProcessor
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
abstract class AbstractProcessor implements ProcessorInterface
{
    /** @type null|UploadedFile $file */
    protected $file = null;

    /**
     * @todo Refactoring?
     *
     * @api
     *
     * @param UploadedFile $file
     *
     * @return AbstractProcessor Provides a fluent interface.
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @api
     *
     * @param string $filename
     *
     * @return File
     *
     * @throws Throws a RuntimeException if the filename cannot be opened.
     */
    public function mapToObject($filename)
    {
        return new File($filename);
    }
}
