<?php
declare(strict_types=1);

namespace Vision\Random;

use DomainException;

final class RandomString
{
    final public static function generateHex(int $length): string
    {
        if ($length < 2) {
            throw new DomainException('Length must be greater than or equal to 2.');
        }

        if (($length % 2) === 1) {
            throw new DomainException('Length must be a multiple of 2.');
        }

        return bin2hex(random_bytes($length / 2));
    }
}
