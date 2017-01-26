<?php
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
