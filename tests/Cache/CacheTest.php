<?php

namespace VisionTest\Cache;

use Vision\Cache\Cache;
use PHPUnit\Framework\TestCase;
use Vision\Cache\Storage\StorageInterface;

class CacheTest extends TestCase
{
    public function testGetStorage()
    {
        $storage = $this->createMock(StorageInterface::class);
        $cache = new Cache($storage);
        $this->assertSame($storage, $cache->getStorage());
    }
}
