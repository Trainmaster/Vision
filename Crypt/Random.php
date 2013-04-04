<?php
namespace Vision\Crypt;

class Random
{
    public function generateBytes($length)
    {        
        $length = (int) $length;
        
        if (strlen($length) <= 0) {
            return false;
        }
        
        if (function_exists('openssl_random_pseudo_bytes')) {
            $length = (int) $length;
            $strong = true;
            $bytes = openssl_random_pseudo_bytes($length, $strong);
            if ($bytes !== false) {
                return $bytes;
            }
        }
        
        if (defined(MCRYPT_DEV_URANDOM)) {
            $bytes = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
            if ($bytes !== false) {
                return $bytes;
            }
        }
        
        return false;
    }
    
    public function generateString($length)
    {
        $length = (int) $length;
        $bytes = $this->generateBytes($length / 2);
        
        if ($bytes !== false) {
            return bin2hex($bytes);
        }
    }
}