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
 * File
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class File extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'file'];

    /** @var array $invalidAttributes */
    protected $invalidAttributes = ['value'];

    /**
     * @param mixed $value
     *
     * @return $this Provides a fluent interface.
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}