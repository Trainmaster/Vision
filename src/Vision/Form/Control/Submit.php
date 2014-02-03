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
 * Submit
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Submit extends AbstractInput
{
    /** @type array $attributes */
    protected $attributes = array('type' => 'submit');

    /** @type array $invalidAttributes */
    protected $invalidAttributes = array('required');
}
