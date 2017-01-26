<?php
declare(strict_types=1);

namespace Vision\Form\Control;

use Vision\Validator;

class Email extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'email'];

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->addValidator(new Validator\Email);
    }
}
