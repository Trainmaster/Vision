<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form\Control;

use Vision\Form\AbstractType;
use Vision\Filter\FilterInterface;
use Vision\Validator;

use LogicException;

/**
 * AbstractControl
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
abstract class AbstractControl extends AbstractType
{
    /** @type array $filters */
    protected $filters = array();

    /** @type array $errors */
    protected $errors = array();

    /** @type null|string $label */
    protected $label;

    /** @type mixed $data */
    protected $data;

    /** @type mixed $value */
    protected $value;

    /** @type bool $forceNull */
    protected $forceNull = true;

    /** @type bool $isValidated */
    protected $isValidated = false;

    /**
     * @api
     *
     * @param FilterInterface $filter
     *
     * @return $this Provides a fluent interface.
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * @api
     *
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
     * @api
     *
     * @return array
     */

    public function getFilters()
    {
        return $this->filters;
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
     * @api
     *
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
     * @api
     *
     * @param bool $value
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
     * @api
     *
     * @return bool
     */
    public function isRequired()
    {
        return (bool) $this->getAttribute('required');
    }

    /**
     * @api
     *
     * @param string $value
     *
     * @return $this Provides a fluent interface.
     */
    public function setPlaceholder($placeholder)
    {
        $this->setAttribute('placeholder', $placeholder);
        return $this;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->getAttribute('placeholder');
    }

    /**
     * @api
     *
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
     * @api
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @api
     *
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
     * @api
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @api
     *
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
     * @api
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @api
     *
     * @param bool $forceNull
     *
     * @return $this Provides a fluent interface.
     */
    public function forceNull($forceNull)
    {
        $this->forceNull = (bool) $forceNull;
        return $this;
    }

    /**
     * @api
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid()
    {
        if ($this->isValidated) {
            throw new LogicException('The element may only be validated once per life-cycle.');
        }

        $value = $this->data;

        if ($this->isRequired()) {
            array_unshift($this->validators, new Validator\InputNotEmptyString, new Validator\NotNull);
        }

        foreach ($this->validators as $validator) {
            if (!$validator->isValid($value)) {
                $key = get_class($validator);
                $this->errors[$key] = $validator->getErrors();
            }
        }

        foreach ($this->filters as $filter) {
            $value = $filter->filter($value);
        }

        if ($this->forceNull && $value === '') {
            $value = null;
        }

        $this->isValidated = true;

        if (empty($this->errors)) {
            $this->setValue($value);
            return true;
        }

        return false;
    }

    /**
     * @internal
     *
     * @return false
     */
    public function hasChildren()
    {
        return false;
    }

    /**
     * @internal
     *
     * @return array
     */
    public function getChildren()
    {
        return array();
    }
}
