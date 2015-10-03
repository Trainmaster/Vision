<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Session\Extension;

use Vision\Session\SessionInterface;

interface ExtensionInterface
{
    public function start();

    public function load(SessionInterface $session);

    public function save(SessionInterface $session);

    public function getStatus();

    public function getId();

    public function regenerateId($deleteOldSession = true);
}
