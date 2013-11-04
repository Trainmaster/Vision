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
 * Bcrypt
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Bcrypt
{
    /** @type int MIN_SALT_LENGTH */
    const MIN_SALT_LENGTH = 16;

    /**
     * @api
     *
     * @param string $password
     * @param int $cost
     * @param string $salt
     *
     * @return bool|string
     */
    public function hash($password, $cost = 10, $salt = null)
    {
        $cost = (int) $cost;

        if ($cost < 4 || $cost > 31) {
            return false;
        }

        $salt = $this->processSalt($salt);

        if ($salt === null) {
            return false;
        }

        $password = (string) $password;

        $hash = crypt($password, '$2y$' . $cost . '$' . $salt);

        if (strlen($hash) < 13) {
            return false;
        }

        return $hash;
    }

    /**
     * @api
     *
     * @param string $password
     * @param string $hash
     *
     * @return bool
     */
    public function verify($password, $hash)
    {
        if (crypt($password, $hash) === $hash) {
            return true;
        }

        return false;
    }

    /**
     * @param string $string
     *
     * @return string|null
     */
    protected function processSalt($string)
    {
        $string = (string) $string;

        if (strlen($string) >= self::MIN_SALT_LENGTH) {
            $salt = substr(str_replace('+', '.', base64_encode($string)), 0, 22);
            return $salt;
        }

        return null;
    }
}
