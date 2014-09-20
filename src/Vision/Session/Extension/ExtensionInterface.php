<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Session\Extension;

use Vision\Session\SessionInterface;

/**
 * SessionAwareInterface
 *
 * @author Frank Liepert
 */
interface ExtensionInterface
{
    public function start();

    public function load(SessionInterface $session);

    public function save(SessionInterface $session);

    public function getStatus();

    public function getId();

    public function regenerateId($deleteOldSession = true);
}
