<?php

declare(strict_types=1);

namespace Vision\Form\Control;

use Vision\Html\Element;

class Radio extends AbstractOptionControl
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'radio'];

    /** @var bool $checkedness */
    protected $checkedness = false;

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
            $html .= $this->getButton($value);
        }

        return $html;
    }

    /**
     * @param string $value
     *
     * @return null|Element
     */
    public function getButton($value)
    {
        if (!parent::hasOption($value)) {
            return null;
        }

        if (isset($this->elements[$value])) {
            return $this->elements[$value];
        }

        return $this->elements[$value] = $this->createRadioButton($value);
    }

    /**
     * @param string $value
     *
     * @return Element
     */
    protected function createRadioButton($value)
    {
        $button = new Element('input');
        $button->setAttributes([
            'value' => $value,
            ] + $this->getAttributes());

        if (!$this->checkedness && parent::checkCheckedness($button->getAttribute('value'))) {
            $button->setAttribute('checked');
            $this->checkedness = true;
        }

        return $button;
    }
}
