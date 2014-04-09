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
 * AbstractOptionControl
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
abstract class AbstractOptionControl extends AbstractControl
{
    /** @type array $options */
    protected $options = array();

    /**
     * @api
     *
     * @param mixed $value
     * @param mixed $label
     *
     * @return $this Provides a fluent interface.
     */
    public function setOption($value, $label)
    {
        $this->options[(string) $value] = (string) $label;
        return $this;
    }

    /**
     * @api
     *
     * @param array $options
     *
     * @return $this Provides a fluent interface.
     */
    public function setOptions(array $options)
    {
        foreach ($options as $value => $label) {
            $this->setOption($value, $label);
        }
        return $this;
    }


    /**
     * @internal
     *
     * @param string $value
     *
     * @return bool
     */
    protected function hasOption($value)
    {
        return isset($this->options[$value]);
    }

    /**
     * @api
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $val
     *
     * @return bool
     */
    public function checkCheckedness($val)
    {
        $value = $this->getValue();

        if (is_array($value)) {
            return in_array($val, $value);
        } elseif (is_scalar($value)) {
            return $val == $value;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        parent::addValidator(new Validator\InArray(array_keys($this->options)));

        return parent::isValid();
    }
}
