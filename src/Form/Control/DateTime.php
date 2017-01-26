<?php
declare(strict_types=1);

namespace Vision\Form\Control;

/**
 * DateTime
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class DateTime extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'datetime'];

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

        parent::setAttribute('value', $value->format(\DateTime::RFC3339));

        $this->value = $value;

        return $this;
    }
}
