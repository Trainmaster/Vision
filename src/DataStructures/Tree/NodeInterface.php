<?php
declare(strict_types=1);

namespace Vision\DataStructures\Tree;

interface NodeInterface
{
    public function setParent(NodeInterface $parent): NodeInterface;

    /**
     * @return null|NodeInterface
     */
    public function getParent();

    public function removeChild(NodeInterface $child);

    public function getChildren(): array;

    public function hasChildren(): bool;
}
