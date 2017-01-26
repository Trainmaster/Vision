<?php
namespace Vision\File;

use InvalidArgumentException;

class UploadedFile extends File
{
    /**
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
