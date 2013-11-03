<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\DataStructures\Tree;

/**
 * NodeInterface
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
interface NodeInterface
{   
    /**
     * @api
     * 
     * @return array
     */
    public function getChildren();
    
    /**
     * @api
     * 
     * @return bool
     */
    public function hasChildren();
}