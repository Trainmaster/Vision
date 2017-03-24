<?php
declare(strict_types = 1);

namespace Vision\DataStructures\Tree;

class Node implements NodeInterface
{
    /** @var null|Node $parent */
    protected $parent;

    /** @var array $children */
    protected $children = [];

    public function setParent(NodeInterface $parent): NodeInterface
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return null|Node
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function addChild(NodeInterface $child): NodeInterface
    {
        $this->children[] = $child->setParent($this);
        return $this;
    }

    public function removeChild(NodeInterface $child)
    {
        $key = array_search($child, $this->children, true);

        if ($key !== false) {
            unset($this->children[$key]);
        }
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function hasChildren(): bool
    {
        return !empty($this->children);
    }

    public function removeChildren(): array
    {
        return $this->children = [];
    }
}
