<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
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
    protected $elements = array();

    /** @var array $validators */
    protected $validators = array();

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
     * @api
     *
     * @return string
     */
    public function getName()
    {
        return $this->getAttribute('name');
    }

    /**
     * @api
     *
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
     * @api
     *
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
     * @api
     *
     * @return array
     */
    public function getValidators()
    {
        return $this->validators;
    }

    /**
     * @api
     *
     * @return $this Provides a fluent interface.
     */
    public function resetValidators()
    {
        $this->validators = array();
        return $this;
    }

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
     * @return null|NodeInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @api
     *
     * @return bool
     */
    public function hasChildren()
    {
        return !empty($this->elements);
    }

    /**
     * @api
     *
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
     * @api
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->elements;
    }
}
