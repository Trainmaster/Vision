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
 * MinStringLength
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class MinStringLength extends AbstractMultibyteStringValidator 
{
    /** @type string STRING_TOO_SHORT */
    const STRING_TOO_SHORT = 'The given string "%s" is too short. The minimum length is "%s"';
    
    /** @type int $min */
	protected $min = null;

    /**
     * @param int $min 
     */
	public function __construct($min) 
	{
        $this->min = (int) $min;
	}
    
    /**
     * @param string $value 
     * 
     * @return bool
     */
    public function __invoke($value)
    {
        return $this->isValid($value);
    }
    
    /**
     * @api
     *
     * @return int
     */
    public function getMin()
    {
        return $this->min;
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
        
		if (mb_strlen($value) >= $this->min) {
			return true;
		}
        
		$this->addError(sprintf(self::STRING_TOO_SHORT, $value, $this->min));
        
		return false;
	}
}