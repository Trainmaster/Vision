<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form\Control;

/**
 * DateTimeLocal
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class DateTimeLocal extends AbstractInput
{
    /** @type array $attributes */
    protected $attributes = array('type' => 'datetime-local');

    /** @type string $dateTimeLocalFormat */
    protected $dateTimeLocalFormat = 'Y-m-d\TH:i:s';

    /**
     * @api
     *
     * @param mixed $value
     *
     * @throws \Exception
     *
     * @return $this Provides a fluent interface.
     */
    public function setValue($value)
    {
        if ($value === null) {
            return parent::setValue($value);
        }

        if (!$value instanceof \DateTime) {
            $value = new \DateTime($value);
        }

        parent::setAttribute('value', $value->format($this->dateTimeLocalFormat));

        $this->value = $value;

        return $this;
    }
}
