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
 * Range
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Range extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'range'];

    /** @var array $invalidAttributes */
    protected $invalidAttributes = ['required'];
}
