<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form\Control;

/**
 * Range
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Range extends AbstractInput
{
    /** @type array $attributes */
    protected $attributes = array('type' => 'range');

    /** @type array $invalidAttributes */
    protected $invalidAttributes = array('required');
}
