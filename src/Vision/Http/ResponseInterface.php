<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Http;

/**
 * ResponseInterface
 *
 * @author Frank Liepert
 */
interface ResponseInterface
{
    /**
     * @api
     *
     * @param string $body
     */
    public function body($body);

    /**
     * @api
     *
     * @param string $name
     * @param string $value
     * @param int    $expire
     * @param string $path
     * @param string $domain
     * @param bool   $secure
     * @param bool   $httponly
     */
    public function addCookie($name, $value = '', $expire = 0, $path = '',
                              $domain = '', $secure = false, $httponly = false);

    /**
     * @api
     *
     * @param string $name
     * @param string $value
     * @param int    $expire
     * @param string $path
     * @param string $domain
     * @param bool   $secure
     * @param bool   $httponly
     */
    public function addRawCookie($name, $value = '', $expire = 0, $path = '',
                                 $domain = '', $secure = false, $httponly = false);

    /**
     * @api
     *
     * @param string $name
     * @param string $value
     */
    public function addHeader($name, $value);

    /**
     * @api
     *
     * @param int $statusCode
     */
    public function setStatusCode($statusCode);

    /**
     * @api
     */
    public function send();
}
