<?php

declare(strict_types=1);

namespace Vision\Form\Control;

class Date extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'date'];

    /** @var string $dateFormat */
    protected $dateFormat = 'Y-m-d';

    /**
     * @param string $dateFormat
     *
     * @return $this Provides a fluent interface
     */
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = (string) $dateFormat;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * @param mixed $value
     *
     * @throws \Exception
     *
     * @return $this Provides a fluent interface.
     */
    public function setValue($value)
    {
        if ($value === null) {
            return parent::setValue($value);
        }

        if (!$value instanceof \DateTime) {
            $value = new \DateTime($value);
        }

        parent::setAttribute('value', $value->format($this->dateFormat));

        $this->value = $value;

        return $this;
    }
}
