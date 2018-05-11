<?php

declare(strict_types=1);

namespace Vision\Routing;

use Vision\Cache\CacheInterface;
use Closure;

class CachedDefinitionLoader implements DefinitionLoaderInterface
{
    /** @var DefinitionLoader */
    private $definitionLoader;

    /** @var CacheInterface */
    private $cache;

    /**
     * @param DefinitionLoader $definitionLoader
     * @param CacheInterface $cache
     */
    public function __construct(DefinitionLoader $definitionLoader, CacheInterface $cache)
    {
        $this->definitionLoader = $definitionLoader;
        $this->cache = $cache;
    }

    /**
     * @param array $resources
     * @return Closure
     * @throws \Exception
     */
    public function load(array $resources): Closure
    {
        $cacheKey = self::getCacheKey($resources);
        $definitionCallback = $this->cache->get($cacheKey);

        if ($definitionCallback) {
            return $definitionCallback;
        }

        $definitionCallback = $this->definitionLoader->load($resources);
        $this->cache->set($cacheKey, $definitionCallback);

        return $definitionCallback;
    }

    /**
     * @param array $resources
     * @return string
     */
    private static function getCacheKey(array $resources): string
    {
        return __CLASS__ . '_' . md5(serialize($resources));
    }
}
