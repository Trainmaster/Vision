<?php
declare(strict_types=1);

namespace Vision\DataStructures\Tree;

use RecursiveIterator;

class NodeIterator implements RecursiveIterator
{
    /** @var array $nodes */
    private $nodes;

    /** @var int $position */
    private $position = 0;

    public function __construct(NodeInterface $node)
    {
        $this->nodes = $node->getChildren();
    }

    public function hasChildren(): bool
    {
        return $this->current()->hasChildren();
    }

    public function getChildren(): NodeIterator
    {
        return new self($this->current());
    }

    public function current(): NodeInterface
    {
        return $this->nodes[$this->position];
    }

    public function key(): int
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

    public function valid(): bool
    {
        return isset($this->nodes[$this->position]);
    }
}
