<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form\Control;

use DateTime;

use InvalidArgumentException;

/**
 * Date
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Date extends AbstractInput
{
    /** @type array $attributes */
    protected $attributes = array('type' => 'date');

    /** @type string $dateFormat */
    protected $dateFormat = 'Y-m-d';

    /**
     * @api
     *
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
     * @api
     *
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * @api
     *
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     *
     * @return $this Provides a fluent interface.
     */
    public function setValue($value)
    {
        if (!$value instanceof DateTime) {
            if (is_string($value) || $value === null) {
                $value = new DateTime($value);            
            } else {
                throw new InvalidArgumentException(sprintf(
                    'Argument 1 must be string, %s given.',
                    gettype($value)
                ));
            }
        }
        
        parent::setAttribute('value', $value->format($this->dateFormat));
        
        $this->value = $value;

        return $this;
    }
}
