<?php
declare(strict_types=1);

namespace Vision\Form;

use Vision\DataStructures\Arrays\Mutator\SquareBracketNotation;
use Vision\DataStructures\Tree\Node;
use Vision\DataStructures\Tree\NodeIterator;

use IteratorAggregate;

class Form extends AbstractCompositeType implements IteratorAggregate
{
    /** @var array $attributes */
    protected $attributes = [
        'action' => '',
        'enctype' => 'multipart/form-data',
        'method' => 'post'
    ];

    /** @var array */
    protected $data = [];

    /** @var array $errors */
    protected $errors = [];

    /** @var array $values */
    protected $values = [];

    /** @var Iterator\ControlsIterator $controlsIterator */
    protected $controlsIterator;

    /** @var Iterator\OptionControlsIterator $optionControlsIterator */
    protected $optionControlsIterator;

    /** @var Node */
    private $node;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setTag('form');

        $node = new Node();
        $node->addChild($this);
        $this->node = $node;

        $this->controlsIterator = new Iterator\ControlsIterator(
            new \RecursiveIteratorIterator(
                new NodeIterator($this->node)
            )
        );
        $this->optionControlsIterator = new Iterator\OptionControlsIterator(
            new \RecursiveIteratorIterator(
                new NodeIterator($this->node)
            )
        );

        $this->data = new SquareBracketNotation();
        $this->values = new SquareBracketNotation();
    }

    /**
     * @return \RecursiveIteratorIterator
     */
    public function getIterator()
    {
        return new \RecursiveIteratorIterator(new NodeIterator($this->node), \RecursiveIteratorIterator::CHILD_FIRST);
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
     * @return string
     */
    public function getAction()
    {
        return $this->getAttribute('action');
    }

    /**
     * @param string $method
     *
     * @return $this Provides a fluent interface.
     */
    public function setMethod($method)
    {
        $this->setAttribute('method', $method);
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->getAttribute('method');
    }

    /**
     * @param string $method
     *
     * @return bool
     */
    public function isMethod($method)
    {
        return strcasecmp($this->getMethod(), $method) === 0;
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
     * @return array
     */
    public function getData()
    {
        return $this->data->getArrayCopy();
    }

    /**
     * @param array $data
     *
     * @return $this Provides a fluent interface.
     */
    public function setValues(array $data)
    {
        $data = new SquareBracketNotation($data);

        foreach ($this->controlsIterator as $element) {
            $value = $data->get($element->getName());
            if ($value !== null) {
                $element->setValue($value);
            }
        }

        unset($data);

        return $this;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values->getArrayCopy();
    }

    /**
     * @param array $data
     *
     * @return $this Provides a fluent interface.
     */
    public function setOptions(array $data)
    {
        $data = new SquareBracketNotation($data);

        foreach ($this->optionControlsIterator as $element) {
            $options = $data->get($element->getName());
            if (is_array($options) && !empty($options)) {
                $element->setOptions($options);
            }
        }

        unset($data);

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
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

        foreach ($this as $element) {
            if ($element->getName() === $name) {
                return $element;
            }
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function removeElement($name)
    {
        foreach ($this as $element) {
            if ($element->getName() === $name) {
                $element->getParent()->removeChild($element);
            }
        }
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        foreach ($this->controlsIterator as $element) {
            $name = $element->getName();

            $element->setData($this->data->get($name));

            if ($element->isValid()) {
                $this->values->set($name, $element->getValue());
            } else {
                $this->errors[$name] = $element->getErrors();
            }
        }

        foreach ($this->validators as $validator) {
            if (!$validator->validate($this)) {
                $key = get_class($validator);
                $this->errors[$key] = $validator->getErrors();
            }
        }

        if (empty($this->errors)) {
            return true;
        }

        $this->values->exchangeArray([]);

        return false;
    }
}
