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
 * ResponseAwareInterface
 *
 * @author Frank Liepert
 */
interface ResponseAwareInterface
{
    public function setResponse(ResponseInterface $response);
}
