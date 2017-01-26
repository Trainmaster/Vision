<?php
declare(strict_types=1);

namespace Vision\Form\Control;

/**
 * Button
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
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
