<?php

declare(strict_types=1);

namespace Vision\Form\Control;

class DateTimeLocal extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'datetime-local'];

    /** @var string $dateTimeLocalFormat */
    protected $dateTimeLocalFormat = 'Y-m-d\TH:i:s';

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

        parent::setAttribute('value', $value->format($this->dateTimeLocalFormat));

        $this->value = $value;

        return $this;
    }
}
