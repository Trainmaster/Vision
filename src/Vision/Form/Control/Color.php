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
 * Color
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Color extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'color'];

    /** @var array $invalidAttributes */
    protected $invalidAttributes = ['required'];
}
