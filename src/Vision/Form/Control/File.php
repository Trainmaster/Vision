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
 * File
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class File extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = array('type' => 'file');

    /** @var array $invalidAttributes */
    protected $invalidAttributes = array('value');

    /**
     * @api
     *
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
