<?php

declare(strict_types=1);

namespace Vision\Form\Control;

abstract class AbstractInput extends AbstractControl
{
     /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setTag('input');
        $this->setRequired(true);
    }
}
