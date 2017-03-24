<?php
declare(strict_types = 1);

namespace Vision\Validator;

class InputInteger extends AbstractValidator
{
    /** @var string INPUT_NOT_INTEGER */
    const INPUT_NOT_INTEGER = 'The given value could not be validated as integer.';

    /** @var null|int $min */
    protected $min;

    /** @var null|int $max */
    protected $max;

    /**
     * @param int $min
     * @param int $max
     */
    public function __construct($min = null, $max = null)
    {
        if (isset($min)) {
            $this->setMin($min);
        }

        if (isset($max)) {
            $this->setMax($max);
        }
    }

    /**
     * @param int $min
     *
     * @return $this Provides a fluent interface.
     */
    public function setMin($min)
    {
        $this->min = (int) $min;
        return $this;
    }

    /**
     * @param int $max
     *
     * @return $this Provides a fluent interface.
     */
    public function setMax($max)
    {
        $this->max = (int) $max;
        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        $this->resetErrors();

        $options = [];

        if (isset($this->min)) {
            $options['options']['min_range'] = $this->min;
        }

        if (isset($this->max)) {
            $options['options']['max_range'] = $this->max;
        }

        $result = filter_var($value, FILTER_VALIDATE_INT, $options);

        if ($result !== false) {
            return true;
        }

        $this->addError(self::INPUT_NOT_INTEGER);

        return false;
    }
}
