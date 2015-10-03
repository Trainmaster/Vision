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
 * Hidden
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Hidden extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'hidden'];

    /** @var array $invalidAttributes */
    protected $invalidAttributes = ['required'];
}
