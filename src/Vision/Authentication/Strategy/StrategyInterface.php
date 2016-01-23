<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Authentication\Strategy;

interface StrategyInterface
{
    /**
     * @param array $data
     *
     * @return \Vision\Authentication\ResultInterface
     */
    public function authenticate(array $data);

    /**
     * @param mixed $identity
     *
     * @return void
     */
    public function invalidate($identity);
}
