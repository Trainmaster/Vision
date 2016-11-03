<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Controller;

use Vision\Http\ResponseInterface;

interface ControllerInterface
{
    /**
     * @return ResponseInterface
     */
    public function __invoke();

    public function preFilter();

    public function postFilter();
}