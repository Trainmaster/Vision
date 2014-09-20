<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Cache;

/**
 * CacheAwareInterface
 *
 * @author Frank Liepert
 */
interface CacheAwareInterface
{
    public function setCache(CacheInterface $cache);
}
