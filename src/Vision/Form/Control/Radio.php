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

class Radio extends MultiOptionAbstractControl
{
    /** @type array $attributes */
    protected $attributes = array('type' => 'radio');

    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setTag('input')
             ->setRequired(true)
             ->addClass('input-' . $this->getAttribute('type'));
    }

    public function addOption($value)
    {
        $option = new self($this->getName());
        $option->setValue($value)
               ->setId($this->getName() . '-' . $value);
        $this->options[$value] = $option;
        return $this;
    }

    public function getOption($value)
    {
        $option = parent::getOption($value);

        if ($option instanceof self && $this->checkForPreSelection($option->getValue())) {
            $option->setAttribute('checked');
        }

        return $option;
    }

    public function setOptions(array $options)
    {
        foreach ($options as $value => $label) {
            $option = new self($this->getName());
            $option->setValue($value);
            $option->setId($this->getName() . '-' . $value);
            $this->options[$label] = $option;
        }
        return $this;
    }
}
