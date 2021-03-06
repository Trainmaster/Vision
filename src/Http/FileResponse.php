<?php

declare(strict_types=1);

namespace Vision\Http;

use Vision\File\File;

class FileResponse extends Response
{
    /** @var File $file */
    protected $file;

    /**
     * @param File|string $file
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
        $this->addHeader('Content-Length', (string) $this->file->getSize());

        $this->sendStatusLine();
        $this->sendHeaders();

        $this->file->fpassthru();
        exit;
    }
}
