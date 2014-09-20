<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Controller;

/**
 * ControllerInterface
 *
 * @author Frank Liepert
 */
interface ControllerInterface
{
    public function preFilter();

    public function postFilter();
}
