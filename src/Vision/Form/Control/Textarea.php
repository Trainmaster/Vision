<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form\Control;

/**
 * Textarea
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Textarea extends AbstractControl
{
    /** @type array $invalidAttributes */
    protected $invalidAttributes = array('value');

    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setTag('textarea');
    }

    /**
     * @api
     *
     * @param int $rows
     *
     * @return $this Provides a fluent interface.
     */
    public function setRows($rows)
    {
        $this->setAttribute('rows', (int) $rows);
        return $this;
    }

    /**
     * @api
     *
     * @param int $cols
     *
     * @return $this Provides a fluent interface.
     */
    public function setCols($cols)
    {
        $this->setAttribute('cols', (int) $cols);
        return $this;
    }

    /**
     * @api
     *
     * @param mixed $value
     *
     * @return $this Provides a fluent interface.
     */
    public function setValue($value)
    {
        $this->clearContents();
        $this->addContent($value);
        $this->value = $value;
        return $this;
    }
}
