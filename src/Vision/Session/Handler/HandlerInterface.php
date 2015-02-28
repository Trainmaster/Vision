<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Session\Handler;

/**
 * HandlerInterface
 *
 * @author Frank Liepert
 */
interface HandlerInterface
{
    public function close();

    public function destroy($sessionId);

    public function gc($maxlifetime);

    public function open($savePath, $name);

    public function read($sessionId);

    public function write($sessionId, $sessionData);
}
