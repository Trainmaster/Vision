<?php
declare(strict_types=1);

namespace Vision\Filter;

interface Filter
{
    /**
     * @param mixed $value
     */
    public function filter($value);
}
