<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form;

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
    protected $iterator = null;

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
     * @return Form Provides a fluent interface.
     */
    public function setAction($action)
    {
        $this->setAttribute('action', $action);
        return $this;
    }

    /**
     * @api
     *
     * @param array $data
     *
     * @return Form Provides a fluent interface.
     */
    public function setValues(array $data)
    {
        $iterator = $this->getIterator();

        foreach ($iterator as $element) {
            if ($element instanceof Control\AbstractControl) {
                $name = $element->getName();
                if (isset($data[$name])) {
                    $element->setValue($data[$name]);
                }
            }
        }

        return $this;
    }

    /**
     * @api
     *
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param array $data
     *
     * @return $this Provides a fluent interface.
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @api
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
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
        if (isset($this->data[$this->getName()])) {
            return true;
        }
        return false;
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
                $rawValue = $this->getValueByName($name);
                $element->setRawValue($rawValue);

                if (!$element->isValid()) {
                    $this->errors[$name] = $element->getErrors();
                    $isValid = false;
                }

                $this->values[$name] = $element->getValue();
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

    /**
     * Retrieve array value by html array notation
     *
     * Example:
     * $this->getValueByName('foo[bar]') returns the value of $this->data['foo']['bar'] or NULL.
     *
     * @internal
     *
     * @param string $name
     *
     * @return mixed
     */
    protected function getValueByName($name)
    {
        if (strpos($name, '[]') !== false) {
            $name = str_replace('[]', '', $name);
        }

        $parts = explode('[', $name);
        $value = $this->data;

        foreach ($parts as $part) {
            $part = rtrim($part, ']');
            if (isset($value[$part])) {
                $value = $value[$part];
            } else {
                return null;
            }
        }

        return $value;
    }
}
