<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form;

use Vision\DataStructures\Arrays\Mutator\SquareBracketNotation;
use Vision\DataStructures\Tree\Node;
use Vision\DataStructures\Tree\NodeIterator;

/**
 * Form
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Form extends AbstractCompositeType
{
    /** @type array $attributes */
    protected $attributes = array(
        'action' => '',
        'enctype' => 'multipart/form-data',
        'method' => 'post'
    );

    /** @type array */
    protected $data = array();

    /** @type array $errors */
    protected $errors = array();

    /** @type array $values */
    protected $values = array();

    /** @type \RecursiveIteratorIterator|null $iterator */
    protected $iterator;

    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setTag('form');

        $node = new Node;
        $node->addChild($this);
        $this->iterator = new \RecursiveIteratorIterator(new NodeIterator($node), \RecursiveIteratorIterator::CHILD_FIRST);

        $this->data = new SquareBracketNotation;
        $this->values = new SquareBracketNotation;
    }

    /**
     * @return \RecursiveIteratorIterator
     */
    public function getIterator()
    {
        return $this->iterator;
    }

    /**
     * @param string $action
     *
     * @return $this Provides a fluent interface.
     */
    public function setAction($action)
    {
        $this->setAttribute('action', $action);
        return $this;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getAction()
    {
        return $this->getAttribute('action');
    }

    /**
     * @param array $data
     *
     * @return $this Provides a fluent interface.
     */
    public function setData(array $data)
    {
        $this->data->exchangeArray($data);
        return $this;
    }

    /**
     * @api
     *
     * @return array
     */
    public function getData()
    {
        return $this->data->getData();
    }

    /**
     * @api
     *
     * @param array $data
     *
     * @return $this Provides a fluent interface.
     */
    public function setValues(array $data)
    {
        $data = new SquareBracketNotation($data);

        $iterator = $this->getIterator();

        foreach ($iterator as $element) {
            var_dump($element);
            $value = $data->get($element->getName());
            if ($value !== null) {
                $element->setValue($value);
            }
        }

        unset($data);

        return $this;
    }

    /**
     * @api
     *
     * @return array
     */
    public function getValues()
    {
        return $this->values->getData();
    }

    /**
     * @api
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @api
     *
     * @return bool
     */
    public function isSent()
    {
        return $this->data->get($this->getName()) !== null;
    }

    /**
     * @api
     *
     * @param string $name
     *
     * @return AbstractType|null
     */
    public function getElement($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException(sprintf(
                'Argument 1 passed to %s must be a string.',
                __METHOD__
            ));
        }

        $name = trim($name);

        $iterator = $this->getIterator();

        foreach ($iterator as $element) {
            if ($element->getName() === $name) {
                return $element;
            }
        }

        return null;
    }

    /**
     * @api
     *
     * @return bool
     */
    public function isValid()
    {
        $isValid = true;

        $iterator = $this->getIterator();

        foreach ($iterator as $element) {
            if ($element instanceof Control\AbstractControl) {
                $name = $element->getName();
                $rawValue = $this->data->get($name);
                $element->setRawValue($rawValue);

                if (!$element->isValid()) {
                    $this->errors[$name] = $element->getErrors();
                    $isValid = false;
                }

                $this->values->set($name, $element->getValue());
            }
        }

        foreach ($this->validators as $validator) {
            if (!$validator->isValid($this)) {
                $key = get_class($validator);
                $this->errors[$key] = $validator->getErrors();
                $isValid = false;
            }
        }

        return $isValid;
    }
}
