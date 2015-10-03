<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Cache;

interface CacheInterface
{
    public function getStorage();

    public function set($key, $value, $expiration);

    public function get($key);
}
