<?php
namespace Vision\Form;

use Vision\DataStructures\Tree\NodeInterface;
use Vision\Html\Element as HtmlElement;
use Vision\Validator\ValidatorInterface;

/**
 * AbstractType
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
abstract class AbstractType extends HtmlElement implements NodeInterface
{
    /** @var array $elements */
    protected $elements = [];

    /** @var ValidatorInterface[] $validators */
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
     * @param ValidatorInterface $validator
     *
     * @return $this Provides a fluent interface.
     */
    public function addValidator(ValidatorInterface $validator)
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
     * @return null|NodeInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return bool
     */
    public function hasChildren()
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

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->elements;
    }
}
