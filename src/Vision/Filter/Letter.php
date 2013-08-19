<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Filter;

/**
 * Letter
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Letter extends PregReplace 
{
    protected $pattern = '/\P{L}/u';
}