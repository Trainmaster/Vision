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
 * Checkbox
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Checkbox extends AbstractOptionControl
{
    /** @type array $attributes */
    protected $attributes = array('type' => 'checkbox');

    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setTag('input');
        $this->setRequired(true);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $html = '';

        foreach ($this->options as $value => $label) {
            $html .= $this->getCheckbox($value);
        }

        return $html;
    }

    /**
     * @api
     *
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
     * @internal
     *
     * @param string $value
     *
     * @return Element
     */
    protected function createCheckbox($value)
    {
        $checkbox = new Element('input');
        $checkbox->setAttributes(array(
            'value' => $value,
        ) + $this->getAttributes());

        if (parent::checkCheckedness($checkbox->getAttribute('value'))) {
            $checkbox->setAttribute('checked');
        }

        return $checkbox;
    }
}
