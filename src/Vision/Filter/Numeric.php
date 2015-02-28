<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Filter;

/**
 * Numeric
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Numeric extends PregReplace
{
    protected $pattern = '/\P{N}/u';
}
