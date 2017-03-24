<?php
declare(strict_types = 1);

namespace Vision\Form\Control;

class Submit extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'submit'];

    /** @var array $invalidAttributes */
    protected $invalidAttributes = ['required'];
}
