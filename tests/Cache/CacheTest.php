<?php
namespace VisionTest\Cache;

use Vision\Cache\Cache;

class CacheTest extends \PHPUnit_Framework_TestCase
{
    public function testGetStorage()
    {
        $storage = $this->createMock('\Vision\Cache\Storage\StorageInterface');
        $cache = new Cache($storage);
        $this->assertSame($storage, $cache->getStorage());
    }
}
