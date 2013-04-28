<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Session;

/**
 * SessionAwareInterface
 *
 * @author Frank Liepert
 */
interface SessionAwareInterface
{
    public function setSession(Session $session);
}