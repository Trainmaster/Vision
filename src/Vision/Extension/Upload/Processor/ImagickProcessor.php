<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Extension\Upload\Processor;

use Vision\Extension\Upload\ImageFile;
use Vision\File\UploadedFile;

use Imagick;

/**
 * ImagickProcessor
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class ImagickProcessor implements ProcessorInterface
{
    /**
     * @return void
     */
    public function __construct()
    {
        if (extension_loaded('Imagick') === false) {
            throw new \RuntimeException('The Imagick extension is required.');
        }
    }

    /**
     * @api
     *
     * @param UploadedFile $file
     * @param string $dest
     *
     * @return string|bool
     */
    public function process(UploadedFile $file, $dest)
    {
        $src = $file->getClientTmpName();
        $im = new Imagick($src);

        $dirname = pathinfo($dest, PATHINFO_DIRNAME);
        $filename = pathinfo($dest, PATHINFO_FILENAME);
        $extension = strtolower($im->getImageFormat());
        
        $data['height'] = $im->getImageHeight();
        $data['width'] = $im->getImageWidth();

        $filename = $dirname . DIRECTORY_SEPARATOR . $filename . '.' . $extension;

        if ($im->writeImage($filename)) {
            $im->destroy();
            $image = new ImageFile($filename);
            $image->exchangeArray($data);
            return $image;
        }

        return false;
    }

    /**
     * @api
     *
     * @return bool
     */
    public function isResponsibleFor(UploadedFile $file)
    {
        $im = new Imagick;
        $formats = $im->queryFormats();
        $extension = strtoupper($file->getClientExtension());
        $im->destroy();

        return in_array($extension, $formats);
    }
}
