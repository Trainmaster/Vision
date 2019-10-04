<?php
declare(strict_types=1);

namespace Vision\Form\Control;

use Vision\Html\Element;

class Checkbox extends AbstractOptionControl
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'checkbox'];

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setTag('input');
        $this->setRequired(true);
    }

    public function __toString(): string
    {
        $html = '';

        foreach ($this->options as $value => $label) {
            $html .= $this->getCheckbox($value);
        }

        return $html;
    }

    /**
     * @param string $value
     *
     * @return null|Element
     */
    public function getCheckbox($value)
    {
        if (!parent::hasOption($value)) {
            return null;
        }

        if (isset($this->elements[$value])) {
            return $this->elements[$value];
        }

        return $this->elements[$value] = $this->createCheckbox($value);
    }

    /**
     * @param string $value
     *
     * @return Element
     */
    protected function createCheckbox($value)
    {
        $checkbox = new Element('input');
        $checkbox->setAttributes([
            'value' => $value,
            ] + $this->getAttributes());

        if (parent::checkCheckedness($checkbox->getAttribute('value'))) {
            $checkbox->setAttribute('checked');
        }

        return $checkbox;
    }
}
