<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form\Control;

use Vision\Html\Element;

/**
 * Select
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Select extends AbstractOptionControl
{
    /** @type array $invalidAttributes */
    protected $invalidAttributes = array('value');

    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setTag('select');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        foreach ($this->options as $value => $label) {
            $this->addContent($this->createOption($value));
        }

        return parent::__toString();
    }

    /**
     * @api
     *
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
     * @api
     *
     * @return int
     */
    public function getSize()
    {
        return $this->getAttribute('size');
    }

    /**
     * @api
     *
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
     * @api
     *
     * @return bool
     */
    public function getMultiple()
    {
        return $this->getAttribute('multiple');
    }

    /**
     * @internal
     *
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
            $option->setAttribute('selected', 'selected');
        }

        return $option;
    }
}
