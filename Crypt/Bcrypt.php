<?php
namespace Vision\Crypt;

class Bcrypt
{
    const MIN_SALT_LENGTH = 16;
    
    public function generateSalt($string)
    {
        $string = (string) $string;
        if (strlen($string) >= self::MIN_SALT_LENGTH) {
            $salt = substr(str_replace('+', '.', base64_encode($string)), 0, 22);
            return $salt;
        }
        return null;
    }
    
    public function hash($password, $cost = 10, $salt = null)
    {
        $password = (string) $password;
        $cost = (int) $cost;
        $salt = $this->generateSalt($salt);
        $hash = crypt($password, '$2y$' . $cost . '$' . $salt);
        if (strlen($hash) < 13) {
            return false;
        }
        return $hash;
    }
    
    public function verify($password, $hash)
    {
        if (crypt($password, $hash) === $hash) {
            return true;
        }
        return false;   
    }
}
