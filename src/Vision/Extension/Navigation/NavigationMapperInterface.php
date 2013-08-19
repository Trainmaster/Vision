<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Extension\Navigation;

/**
 * NavigationMapperInterface
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
interface NavigationMapperInterface
{
    /**
     * @api
     *
     * @param int $id 
     * @param int $languageId 
     */
    public function loadByIdAndLanguageId($id, $languageId);
}