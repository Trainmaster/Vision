<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Authentication;

interface ResultInterface
{
    /**
     * @return bool
     */
    public function isSuccess();

    /**
     * @return mixed
     */
    public function getIdentity();
}