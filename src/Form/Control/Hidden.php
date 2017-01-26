<?php
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
