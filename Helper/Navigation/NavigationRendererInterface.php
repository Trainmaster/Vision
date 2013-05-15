<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Helper\Navigation;

/**
 * @author Frank Liepert
 */
interface NavigationRendererInterface
{
    /**
     * @param array $tree 
     */
    public function render(array $tree);
}