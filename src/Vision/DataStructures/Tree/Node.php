<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\DataStructures\Tree;

class Node implements NodeInterface
{
    /** @var null|Node $parent */
    protected $parent;

    /** @var array $children */
    protected $children = array();

    /**
     * @api
     *
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
     * @api
     *
     * @return null|Node
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @api
     *
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
     * @api
     *
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
     * @api
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @api
     *
     * @return bool
     */
    public function hasChildren()
    {
        return !empty($this->children);
    }

    /**
     * @api
     *
     * @return array
     */
    public function removeChildren()
    {
        return $this->children = array();
    }
}
