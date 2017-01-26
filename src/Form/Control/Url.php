<?php
declare(strict_types=1);

namespace Vision\Form\Control;

/**
 * Url
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Url extends Text
{
    /** @var array $attributes */
    protected $attributes = ['type' => 'url'];
}
