<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form\Control;

/**
 * Date
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Date extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'date'];

    /** @var string $dateFormat */
    protected $dateFormat = 'Y-m-d';

    /**
     * @param string $dateFormat
     *
     * @return $this Provides a fluent interface
     */
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = (string) $dateFormat;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
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

        parent::setAttribute('value', $value->format($this->dateFormat));

        $this->value = $value;

        return $this;
    }
}