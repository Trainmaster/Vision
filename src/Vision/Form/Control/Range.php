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
 * Range
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Range extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = array('type' => 'range');

    /** @var array $invalidAttributes */
    protected $invalidAttributes = array('required');
}
