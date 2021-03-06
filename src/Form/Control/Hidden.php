<?php

declare(strict_types=1);

namespace Vision\Form\Control;

class Hidden extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'hidden'];

    /** @var array $invalidAttributes */
    protected $invalidAttributes = ['required'];
}
