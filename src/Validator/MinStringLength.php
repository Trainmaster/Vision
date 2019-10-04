<?php

declare(strict_types=1);

namespace Vision\Validator;

class MinStringLength extends AbstractMultibyteStringValidator
{
    /** @var int $min */
    protected $min;

    /** @var string STRING_TOO_SHORT */
    private const STRING_TOO_SHORT = 'The given string "%s" is too short. The minimum length is %s.';

    /**
     * @param int $min
     */
    public function __construct($min)
    {
        $this->min = (int) $min;
    }

    /**
     * @return int
     */
    public function getMin(): int
    {
        return $this->min;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function validate($value): bool
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
