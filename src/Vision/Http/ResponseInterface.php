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
     */
    public function send();
}