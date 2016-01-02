<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Http;

interface ResponseInterface
{
    /**
     * @api
     *
     * @param string $body
     *
     * @return $this
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
     *
     * @return $this
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
     *
     * @return $this
     */
    public function addRawCookie($name, $value = '', $expire = 0, $path = '',
                                 $domain = '', $secure = false, $httponly = false);

    /**
     * @api
     *
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function addHeader($name, $value);

    /**
     * @api
     *
     * @param int $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode);

    /**
     * @api
     *
     * @return void
     */
    public function send();
}
