<?php
namespace Vision\Validator;

class MaxStringLength extends AbstractMultibyteStringValidator
{
    /** @var string STRING_TOO_SHORT */
    const STRING_TOO_LONG = 'The given string "%s" is too long. The maximum length is %s.';

    /** @var int $max */
    protected $max;

    /**
     * @param int $max
     */
    public function __construct($max)
    {
        $this->max = (int) $max;
    }

    /**
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        $this->resetErrors();

        $this->checkEncoding($value);

        if (mb_strlen($value) <= $this->max) {
            return true;
        }

        $this->addError(sprintf(self::STRING_TOO_LONG, $value, $this->max));

        return false;
    }
}
