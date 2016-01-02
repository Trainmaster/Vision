<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Http;

interface RequestInterface
{
    public function getHost();

    public function getMethod();

    public function getPath();

    public function getPathInfo();

    public function getScheme();
}
