<?php
namespace VisionTest\File;

use Vision\File\File;

class FileTest extends \PHPUnit_Framework_TestCase
{
    /** @var File $file */
    protected $file;

    public function setUp()
    {
        $this->file = new File(__DIR__ . '/test.gif');
    }

    public function testGetMimeType()
    {
        $this->assertSame('image/gif; charset=binary', $this->file->getMimeType());
    }
}
