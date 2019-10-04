<?php

namespace VisionTest\Cache;

use Vision\Cache\Cache;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{
    public function testGetStorage()
    {
        $storage = $this->createMock('\Vision\Cache\Storage\StorageInterface');
        $cache = new Cache($storage);
        $this->assertSame($storage, $cache->getStorage());
    }
}
