<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Session;

interface SessionInterface
{
    public function clear();

    public function start();

    public function getStatus();

    public function getId();

    public function regenerateId($deleteOldSession = true);

    public function exchangeArray(array $data);

    public function getArrayCopy();
}
