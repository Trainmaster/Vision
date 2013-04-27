<?php
namespace Vision\Crypt;

class Bcrypt
{
    /**
     * @type int
     */
    const MIN_SALT_LENGTH = 16;
    
    /**
     * @param string $string 
     * 
     * @return string|null
     */
    public function generateSalt($string)
    {
        $string = (string) $string;
        
        if (strlen($string) >= self::MIN_SALT_LENGTH) {
            $salt = substr(str_replace('+', '.', base64_encode($string)), 0, 22);
            return $salt;
        }
        
        return null;
    }
    
    /**
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
        
        $salt = $this->generateSalt($salt);
        
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
}
