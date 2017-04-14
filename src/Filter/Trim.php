<?php
declare(strict_types = 1);

namespace Vision\Filter;

class Trim implements Filter
{
    public function filter($value): string
    {
        return trim($value);
    }
}
