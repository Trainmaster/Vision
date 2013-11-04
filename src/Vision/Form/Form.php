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
use Vision\Http\RequestInterface;
use Vision\Html\Element as HtmlElement;
use Vision\View\Html\ElementAbstract as HtmlElementViewAbstract;

use RecursiveIteratorIterator;
use InvalidArgumentException;

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

    /** @type RecursiveIteratorIterator|null $iterator */
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
     * @return RecursiveIteratorIterator
     */
    public function getIterator()
    {
        if ($this->iterator === null) {
            $node = new Node;
            $node->addChild($this);
            $this->iterator = new RecursiveIteratorIterator(new NodeIterator($node), RecursiveIteratorIterator::CHILD_FIRST);
        }

        return $this->iterator;
    }

    /**
     * @api
     *
     * @param mixed $name
     *
     * @return mixed
     */
    public function getElement($mixed)
    {
        if (is_string($mixed)) {
            $name = trim($mixed);
        } elseif ($mixed instanceof Control\AbstractControl) {
            $name = $mixed->getName();
        } else {
            throw new InvalidArgumentException('');
        }

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
     * @param array $data
     *
     * @return Form Provides a fluent interface.
     */
    public function setValues(array $data)
    {
        $iterator = $this->getIterator();

        foreach ($iterator as $element) {
            $name = $element->getName();
            if (isset($data[$name])) {
                $element->setValue($data[$name]);
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
    public function bindData(array $data)
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

                if (!$element->isRequired() && empty($rawValue)) {
                    continue;
                }

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
     * Example: $this->getValueByName(foo[bar][baz]) returns
     *          the value of $this->data[$foo][$bar][$baz] or NULL.
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
