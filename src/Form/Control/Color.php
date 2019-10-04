<?php

declare(strict_types=1);

namespace Vision\Form\Control;

class Color extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'color'];

    /** @var array $invalidAttributes */
    protected $invalidAttributes = ['required'];
}
