<?php
declare(strict_types=1);

namespace Vision\Form\Control;

/**
 * AbstractInput
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
abstract class AbstractInput extends AbstractControl
{
     /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setTag('input')
             ->setRequired(true);
    }
}
