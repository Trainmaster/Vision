<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form\Control;

use Vision\Validator;

/**
 * Checkbox
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Checkbox extends MultiOptionAbstractControl
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

        foreach ($this->options as $option => $label) {
            $this->removeAttribute('checked');
            $this->setLabel($label);
            $this->setAttribute('value', $option);

            if ($this->checkForPreSelection($option)) {
                $this->setAttribute('checked', 'checked');
            }

            $html .= parent::__toString();
        }

        return $html;
    }
}
