<?php
declare(strict_types=1);

namespace Vision\DataStructures\Tree;

class NodeIterator implements \RecursiveIterator
{
    /** @var array $nodes */
    private $nodes;

    /** @var int $position */
    private $position = 0;

    /**
     * @param NodeInterface $node
     */
    public function __construct(NodeInterface $node)
    {
        $this->nodes = $node->getChildren();
    }

    public function hasChildren()
    {
        return $this->current()->hasChildren();
    }

    public function getChildren()
    {
        return new self($this->current());
    }

    public function current()
    {
        return $this->nodes[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->position++;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        return isset($this->nodes[$this->position]);
    }
}
