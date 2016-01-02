<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Validator;

class MinStringLength extends AbstractMultibyteStringValidator
{
    /** @var string STRING_TOO_SHORT */
    const STRING_TOO_SHORT = 'The given string "%s" is too short. The minimum length is %s.';

    /** @var int $min */
    protected $min;

    /**
     * @param int $min
     */
    public function __construct($min)
    {
        $this->min = (int) $min;
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
        $this->resetErrors();

        $this->checkEncoding($value);

        if (mb_strlen($value) >= $this->min) {
            return true;
        }

        $this->addError(sprintf(self::STRING_TOO_SHORT, $value, $this->min));

        return false;
    }
}
