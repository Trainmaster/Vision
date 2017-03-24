<?php
declare(strict_types = 1);

namespace Vision\Http;

use Vision\File\File;

class FileResponse extends Response
{
    /** @var string $file */
    protected $file;

    /**
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
     * @return void
     */
    public function send()
    {
        $this->addHeader('Content-Type', $this->file->getMimeType());
        $this->addHeader('Content-Length', $this->file->getSize());

        $this->sendStatusLine()
             ->sendHeaders();

        $this->file->fpassthru();
        exit;
    }
}
