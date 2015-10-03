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
 * Time
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Time extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'time'];

    /** @var string $timeFormat */
    protected $timeFormat = 'H:i';

    /**
     * @api
     *
     * @param string $timeFormat
     *
     * @return $this Provides a fluent interface
     */
    public function setTimeFormat($timeFormat)
    {
        $this->timeFormat = (string) $timeFormat;
        return $this;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getTimeFormat()
    {
        return $this->timeFormat;
    }

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

        parent::setAttribute('value', $value->format($this->timeFormat));

        $this->value = $value;

        return $this;
    }
}
