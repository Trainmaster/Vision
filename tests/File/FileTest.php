<?php

namespace VisionTest\File;

use Vision\File\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /** @var File $file */
    protected $file;

    protected function setUp(): void
    {
        $this->file = new File(__DIR__ . '/test.gif');
    }

    public function testGetMimeType()
    {
        $this->assertSame('image/gif; charset=binary', $this->file->getMimeType());
    }
}
