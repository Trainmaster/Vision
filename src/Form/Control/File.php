<?php
declare(strict_types=1);

namespace Vision\Form\Control;

class File extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'file'];

    /** @var array $invalidAttributes */
    protected $invalidAttributes = ['value'];

    /**
     * @param mixed $value
     *
     * @return $this Provides a fluent interface.
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
