<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Validator;

/**
 * MaxStringLength
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class MaxStringLength extends AbstractMultibyteStringValidator 
{
    /** @type string STRING_TOO_SHORT */
    const STRING_TOO_LONG = 'The given string "%s" is too long. The maximum length is "%s"';
    
    /** @type int $max */
    protected $max = null;

    /**
     * @param int $min 
     */
    public function __construct($max) 
    {
        $this->max = (int) $max;
    }
    
    /**
     * @api
     *
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }
    
    /**
     * @api
     * 
     * @param string $value 
     * 
     * @return bool
     */
    public function isValid($value) 
    {           
        $this->value = $value;
        
        $this->checkEncoding();

        if (mb_strlen($value) <= $this->max) {
            return true;
        }
        
        $this->addError(sprintf(self::STRING_TOO_LONG, $value, $this->max));
        
        return false;
    }
}