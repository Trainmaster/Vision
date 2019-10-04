<?php
declare(strict_types=1);

namespace Vision\Form;

use Vision\DataStructures\Tree\NodeInterface;
use Vision\Html\Element as HtmlElement;
use Vision\Validator\Validator;

abstract class AbstractType extends HtmlElement implements NodeInterface
{
    /** @var array $elements */
    protected $elements = [];

    /** @var Validator[] $validators */
    protected $validators = [];

    /** @var null|NodeInterface $parent */
    private $parent;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setAttribute('name', trim($name));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getAttribute('name');
    }

    /**
     * @param Validator $validator
     *
     * @return $this Provides a fluent interface.
     */
    public function addValidator(Validator $validator)
    {
        $this->validators[] = $validator;
        return $this;
    }

    /**
     * @param array $validators
     *
     * @return $this Provides a fluent interface.
     */
    public function addValidators(array $validators)
    {
        foreach ($validators as $validator) {
            $this->addValidator($validator);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getValidators()
    {
        return $this->validators;
    }

    /**
     * @return $this Provides a fluent interface.
     */
    public function resetValidators()
    {
        $this->validators = [];
        return $this;
    }

    public function setParent(NodeInterface $parent): NodeInterface
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return null|NodeInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function hasChildren(): bool
    {
        return !empty($this->elements);
    }

    /**
     * @param NodeInterface $node
     *
     * @return void
     */
    public function removeChild(NodeInterface $node)
    {
        $key = array_search($node, $this->elements, true);

        if ($key !== false) {
            unset($this->elements[$key]);
        }

        $this->elements = array_values($this->elements);
    }

    public function getChildren(): array
    {
        return $this->elements;
    }
}
