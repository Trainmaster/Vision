<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Authentication\Strategy;

/**
 * StrategyInterface
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
interface StrategyInterface
{
    /**
     * @api
     *
     * @param array $data
     *
     * @return \Vision\Authentication\ResultInterface
     */
    public function authenticate(array $data);

    /**
     * @api
     *
     * @param mixed $identity
     *
     * @return void
     */
    public function invalidate($identity);
}
