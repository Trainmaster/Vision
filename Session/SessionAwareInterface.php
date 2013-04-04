<?php
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