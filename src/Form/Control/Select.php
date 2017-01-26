<?php
declare(strict_types=1);

namespace Vision\Form\Control;

use Vision\Html\Element;

/**
 * Select
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Select extends AbstractOptionControl
{
    /** @var array $invalidAttributes */
    protected $invalidAttributes = ['value'];

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setTag('select');
        $this->setRequired(true);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->options)) {
            return '';
        }

        foreach ($this->options as $value => $label) {
            $this->addContent($this->createOption($value));
        }

        return parent::__toString();
    }

    /**
     * @param int $size
     *
     * @return $this Provides a fluent interface.
     */
    public function setSize($size)
    {
        $this->setAttribute('size', (int) $size);
        return $this;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->getAttribute('size');
    }

    /**
     * @param bool $multiple
     *
     * @return $this Provides a fluent interface.
     */
    public function setMultiple($multiple)
    {
        $multiple = (bool) $multiple;

        if ($multiple) {
            $this->setAttribute('multiple');
        } else {
            $this->removeAttribute('multiple');
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function getMultiple()
    {
        return $this->getAttribute('multiple');
    }

    /**
     * @param string $value
     *
     * @return null|Element
     */
    public function getOption($value)
    {
        if (!parent::hasOption($value)) {
            return null;
        }

        if (isset($this->elements[$value])) {
            return $this->elements[$value];
        }

        return $this->elements[$value] = $this->createOption($value);
    }

    /**
     * @param string $value
     *
     * @return Element
     */
    protected function createOption($value)
    {
        $option = new Element('option');
        $option->setAttribute('value', $value);
        $option->addContent($this->options[$value]);

        if ($this->checkCheckedness($value)) {
            $option->setAttribute('selected');
        }

        return $option;
    }
}
