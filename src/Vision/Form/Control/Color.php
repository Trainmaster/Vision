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
 * Color
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Color extends AbstractInput
{
    /** @type array $attributes */
    protected $attributes = array('type' => 'color');

    /** @type array $invalidAttributes */
    protected $invalidAttributes = array('required');
}
