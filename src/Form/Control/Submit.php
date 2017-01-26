<?php
namespace Vision\Form\Control;

/**
 * Submit
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Submit extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'submit'];

    /** @var array $invalidAttributes */
    protected $invalidAttributes = ['required'];
}
