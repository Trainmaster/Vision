<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
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

    public function destroy($session_id);

    public function gc($maxlifetime);

    public function open($save_path, $name);

    public function read($session_id);

    public function write($session_id, $session_data);
}
