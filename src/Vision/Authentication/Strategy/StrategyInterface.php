<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
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
     * @return bool
     */
    public function authenticate(array $data);

    /**
     * @return array
     */
    public function getIdentity();    
    
    /**
     * @return void
     */
    public function invalidate($identity);
}
