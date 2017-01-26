<?php
declare(strict_types=1);

namespace Vision\Random;

class RandomString
{
    /**
     * @param int $length
     *
     * @return bool|string
     */
    public function generateHex($length)
    {
        $length = (int) $length;

        if ($length < 2 || (($length % 2) === 1)) {
            return false;
        }

        $bytes = random_bytes($length / 2);

        return $bytes ? bin2hex($bytes) : false;
    }
}
