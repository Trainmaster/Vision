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
 * DateTime
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class DateTime extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'datetime'];

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

        parent::setAttribute('value', $value->format(\DateTime::RFC3339));

        $this->value = $value;

        return $this;
    }
}
