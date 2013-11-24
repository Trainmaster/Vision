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
    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setTag('input')
             ->setAttribute('type', 'radio')
             ->addClass('input-' . $this->getAttribute('type'));
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
