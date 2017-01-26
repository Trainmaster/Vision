<?php
namespace Vision\Form\Control;

/**
 * Textarea
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Textarea extends AbstractControl
{
    /** @var array $invalidAttributes */
    protected $invalidAttributes = ['value'];

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setTag('textarea');
    }

    /**
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
