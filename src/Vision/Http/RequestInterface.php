<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Http;

/**
 * RequestInterface
 *
 * @author Frank Liepert
 */
interface RequestInterface
{
    public function getMethod();

    public function getPath();

    public function getPathInfo();
}
