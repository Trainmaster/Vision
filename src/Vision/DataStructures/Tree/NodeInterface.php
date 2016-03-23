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
     * @param NodeInterface $parent
     *
     * @return $this Provides a fluent interface.
     */
    public function setParent(NodeInterface $parent);

    /**
     * @return null|NodeInterface
     */
    public function getParent();

    /**
     * @param NodeInterface$child
     *
     * @return void
     */
    public function removeChild(NodeInterface $child);

    /**
     * @return array
     */
    public function getChildren();

    /**
     * @return bool
     */
    public function hasChildren();
}
