<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\DependencyInjection;

/**
 * ContainerInterface
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
interface ContainerInterface
{
    /**
     * @param string $alias
     */
    public function get($alias);
}
