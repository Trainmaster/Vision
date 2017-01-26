<?php
namespace Vision\Form\Control;

/**
 * Number
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Number extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'number'];

    /**
     * @param int $min
     *
     * @return Number Provides a fluent interface.
     */
    public function setMin($min)
    {
        $this->setAttribute('min', (int) $min);
        return $this;
    }

    /**
     * @param int $max
     *
     * @return Number Provides a fluent interface.
     */
    public function setMax($max)
    {
        $this->setAttribute('max', (int) $max);
        return $this;
    }
}
