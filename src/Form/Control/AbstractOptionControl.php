<?php

declare(strict_types=1);

namespace Vision\Form\Control;

use Vision\Validator;

abstract class AbstractOptionControl extends AbstractControl
{
    /** @var array $options */
    protected $options = [];

    /**
     * @param mixed $value
     * @param mixed $label
     *
     * @return $this Provides a fluent interface.
     */
    public function setOption($value, $label)
    {
        $this->options[(string) $value] = (string) $label;
        return $this;
    }

    /**
     * @param array $options
     *
     * @return $this Provides a fluent interface.
     */
    public function setOptions(array $options)
    {
        foreach ($options as $value => $label) {
            $this->setOption($value, $label);
        }
        return $this;
    }


    /**
     * @param string $value
     *
     * @return bool
     */
    protected function hasOption($value)
    {
        return isset($this->options[$value]);
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $val
     *
     * @return bool
     */
    public function checkCheckedness($val)
    {
        $value = $this->getValue();

        if (is_array($value)) {
            return in_array($val, $value);
        } elseif (is_scalar($value)) {
            return $val == $value;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        parent::addValidator(new Validator\InArray(array_keys($this->options), false));

        return parent::isValid();
    }
}
