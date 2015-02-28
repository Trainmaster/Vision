<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form\Control;

use Vision\Html\Element;

/**
 * Radio
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Radio extends AbstractOptionControl
{
    /** @var array $attributes */
    protected $attributes = array('type' => 'radio');

    /** @var bool $checkedness */
    protected $checkedness = false;

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
            $html .= $this->getButton($value);
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
     * @internal
     *
     * @param string $value
     *
     * @return Element
     */
    protected function createRadioButton($value)
    {
        $button = new Element('input');
        $button->setAttributes(array(
            'value' => $value,
        ) + $this->getAttributes());

        if (!$this->checkedness && parent::checkCheckedness($button->getAttribute('value'))) {
            $button->setAttribute('checked');
            $this->checkedness = true;
        }

        return $button;
    }
}
