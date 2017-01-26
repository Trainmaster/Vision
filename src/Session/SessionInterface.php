<?php
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
