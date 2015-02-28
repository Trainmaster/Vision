<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Session;

/**
 * SessionInterface
 *
 * @author Frank Liepert
 */
interface SessionInterface
{
    public function clear();

    public function start();

    public function getStatus();

    public function getId();

    public function regenerateId($deleteOldSession = true);
}
