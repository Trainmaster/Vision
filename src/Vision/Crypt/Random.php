<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Crypt;

/**
 * Random
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Random
{
    /**
     * @api
     *
     * @param int $length
     *
     * @return bool|string
     */
    public function generateBytes($length)
    {
        $length = (int) $length;

        if ($length <= 0) {
            return false;
        }

        if (function_exists('openssl_random_pseudo_bytes')) {
            $cryptoStrong = true;
            $bytes = openssl_random_pseudo_bytes($length, $cryptoStrong);
            if ($bytes !== false) {
                return $bytes;
            }
        }

        if (function_exists('mcrypt_create_iv') && defined(MCRYPT_DEV_URANDOM)) {
            $bytes = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
            if ($bytes !== false) {
                return $bytes;
            }
        }

        return false;
    }

    /**
     * @api
     *
     * @param int $length
     *
     * @return bool|string
     */
    public function generateHex($length)
    {
        $length = (int) $length;

        if ($length <= 0) {
            return false;
        }

        $bytes = $this->generateBytes($length / 2);

        if ($bytes !== false) {
            return bin2hex($bytes);
        }

        return false;
    }
}
