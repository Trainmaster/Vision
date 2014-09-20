<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Filter;

/**
 * FilterInterface
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
interface FilterInterface
{
    /**
     * @param mixed $value
     */
    public function filter($value);
}
