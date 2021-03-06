<?php

declare(strict_types=1);

namespace Vision\Form\Control;

use Vision\Form\AbstractType;
use Vision\Filter\Filter;
use Vision\Validator;
use LogicException;

abstract class AbstractControl extends AbstractType
{
    /** @var null|string $label */
    protected $label;

    /** @var null|mixed $data */
    protected $data;

    /** @var null|mixed $value */
    protected $value;

    /** @var bool $isValidated */
    protected $isValidated = false;

    /** @var array $filters */
    protected $filters = [];

    /** @var array $errors */
    protected $errors = [];

    /**
     * @param string $label
     *
     * @return $this Provides a fluent interface.
     */
    public function setLabel($label)
    {
        $this->label = (string) $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $placeholder
     *
     * @return $this Provides a fluent interface.
     */
    public function setPlaceholder($placeholder)
    {
        $this->setAttribute('placeholder', $placeholder);
        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->getAttribute('placeholder');
    }

    /**
     * @param bool $disabled
     *
     * @return $this Provides a fluent interface.
     */
    public function setDisabled($disabled)
    {
        $disabled = (bool) $disabled;

        if ($disabled) {
            $this->setAttribute('disabled');
        } else {
            $this->removeAttribute('disabled');
        }

        return $this;
    }

    /**
     * @param bool $readOnly
     *
     * @return $this Provides a fluent interface.
     */
    public function setReadOnly($readOnly)
    {
        $readOnly = (bool) $readOnly;

        if ($readOnly) {
            $this->setAttribute('readonly');
        } else {
            $this->removeAttribute('readonly');
        }

        return $this;
    }

    /**
     * @param bool $required
     *
     * @return $this Provides a fluent interface.
     */
    public function setRequired($required)
    {
        $required = (bool) $required;

        if ($required) {
            $this->setAttribute('required');
        } else {
            $this->removeAttribute('required');
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return (bool) $this->getAttribute('required');
    }

    /**
     * @param mixed $data
     *
     * @return $this Provides a fluent interface.
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $value
     *
     * @return $this Provides a fluent interface.
     */
    public function setValue($value)
    {
        $this->setAttribute('value', $value);
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        if ($this->isValidated) {
            throw new LogicException('The element may only be validated once per life-cycle.');
        }

        $value = $this->data;

        if ($this->isRequired()) {
            array_unshift($this->validators, new Validator\InputNotEmptyString(), new Validator\NotNull());
        }

        foreach ($this->validators as $validator) {
            if (!$validator->validate($value)) {
                $key = get_class($validator);
                $this->errors[$key] = $validator->getErrors();
            }
        }

        foreach ($this->filters as $filter) {
            $value = $filter->filter($value);
        }

        $this->isValidated = true;

        if (empty($this->errors)) {
            $this->setValue($value);
            return true;
        }

        return false;
    }

    /**
     * @param Filter $filter
     *
     * @return $this Provides a fluent interface.
     */
    public function addFilter(Filter $filter)
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * @param array $filters
     *
     * @return $this Provides a fluent interface.
     */
    public function addFilters(array $filters)
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
        return $this;
    }

    /**
     * @return array
     */

    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function hasChildren(): bool
    {
        return false;
    }

    public function getChildren(): array
    {
        return [];
    }
}
