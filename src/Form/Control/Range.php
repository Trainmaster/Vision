<?php

declare(strict_types=1);

namespace Vision\Form\Control;

class Range extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'range'];

    /** @var array $invalidAttributes */
    protected $invalidAttributes = ['required'];
}
