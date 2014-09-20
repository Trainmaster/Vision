<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Debug;

/**
 * ExceptionHandlerInterface
 *
 * @author Frank Liepert
 */
interface ExceptionHandlerInterface
{
    public function handle(\Exception $exception);
}
