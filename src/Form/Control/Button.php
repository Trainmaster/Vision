<?php
declare(strict_types=1);

namespace Vision\Form\Control;

class Button extends AbstractControl
{
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setTag('button')
             ->setRequired(true);
    }
}
