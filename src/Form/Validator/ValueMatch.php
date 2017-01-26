<?php
declare(strict_types=1);

namespace Vision\Form\Validator;

use Vision\Form\AbstractCompositeType;
use Vision\Validator\AbstractValidator;

class ValueMatch extends AbstractValidator
{
    /** @var string NO_MATCH */
    const NOT_UNIQUE = 'The given controls %s do not match.';

    /** @var array $controls */
    protected $controls = [];

    /**
     * @param array $controls
     *
     * @return ValueMatch Provides a fluent interface.
     */
    public function setControls(array $controls)
    {
        $this->controls = $controls;

        return $this;
    }

    /**
     * @param AbstractCompositeType $form
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function isValid($form)
    {
        if (!($form instanceof AbstractCompositeType)) {
            throw new \InvalidArgumentException(sprintf(
                'Argument 1 passed to %s must be an instance of %s.',
                __METHOD__,
                'Vision\Form\AbstractCompositeType'
            ));
        }

        $values = [];

        foreach ($this->controls as $control) {
            $values[] = $control->getValue();
        }

        $unique = array_unique($values);

        $count = count($unique);

        if ($count === 1) {
            return true;
        }

        $names = [];

        foreach ($this->controls as $control) {
            $names[] = $control->getLabel();
        }

        $this->addError(sprintf(self::NOT_UNIQUE, '"' . implode($names, '", "') . '"'));

        return false;
    }
}
