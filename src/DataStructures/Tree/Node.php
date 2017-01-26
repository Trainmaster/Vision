<?php
declare(strict_types=1);

namespace Vision\DataStructures\Tree;

class Node implements NodeInterface
{
    /** @var null|Node $parent */
    protected $parent;

    /** @var array $children */
    protected $children = [];

    /**
     * @param NodeInterface $parent
     *
     * @return $this Provides a fluent interface.
     */
    public function setParent(NodeInterface $parent)
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

    /**
     * @param NodeInterface $child
     *
     * @return $this Provides a fluent interface.
     */
    public function addChild(NodeInterface $child)
    {
        $this->children[] = $child->setParent($this);
        return $this;
    }

    /**
     * @param NodeInterface $child
     *
     * @return void
     */
    public function removeChild(NodeInterface $child)
    {
        $key = array_search($child, $this->children, true);

        if ($key !== false) {
            unset($this->children[$key]);
        }

        $this->children = array_values($this->children);
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return bool
     */
    public function hasChildren()
    {
        return !empty($this->children);
    }

    /**
     * @return array
     */
    public function removeChildren()
    {
        return $this->children = [];
    }
}
