<?php
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
