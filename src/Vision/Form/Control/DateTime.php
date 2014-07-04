<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form\Control;

use DateTime as NativeDateTime;

/**
 * DateTime
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class DateTime extends AbstractInput
{
    /** @type array $attributes */
    protected $attributes = array('type' => 'datetime');
    
    /**
     * @api
     *
     * @param mixed $value
     *
     * @throws Exception
     *
     * @return $this Provides a fluent interface.
     */
    public function setValue($value)
    {
        if ($value === null) {
            return parent::setValue($value);
        }

        if (!$value instanceof NativeDateTime) {
            $value = new NativeDateTime($value);
        }

        parent::setAttribute('value', $value->format(NativeDateTime::RFC3339));

        $this->value = $value;

        return $this;
    }
}
