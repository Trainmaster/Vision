<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Random;

class String
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
