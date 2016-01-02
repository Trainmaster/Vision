<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\DataStructures\Tree;

interface NodeInterface
{
    /**
     * @api
     *
     * @param NodeInterface $parent
     *
     * @return $this Provides a fluent interface.
     */
    public function setParent(NodeInterface $parent);

    /**
     * @api
     *
     * @return null|NodeInterface
     */
    public function getParent();

    /**
     * @api
     *
     * @param NodeInterface$child
     *
     * @return void
     */
    public function removeChild(NodeInterface $child);

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
