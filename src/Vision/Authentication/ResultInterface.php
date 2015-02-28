<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Authentication;

/**
 * Authentication
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
interface ResultInterface
{
    /**
     * @api
     *
     * @return bool
     */
    public function isSuccess();

    /**
     * @api
     *
     * @return mixed
     */
    public function getIdentity();
}
