<?php

declare(strict_types=1);

namespace Vision\Validator;

class PregMatch extends AbstractValidator
{
    /** @var null|string $pattern */
    protected $pattern;

    /** @var string NO_MATCH_FOUND */
    private const NO_MATCH_FOUND = 'No match was found.';

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if (isset($options['pattern'])) {
            $this->setPattern($options['pattern']);
        }
    }

    /**
     * @param string $pattern
     *
     * @return $this Provides a fluent interface.
     */
    public function setPattern($pattern): self
    {
        $this->pattern = (string) $pattern;
        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function validate($value): bool
    {
        $this->resetErrors();

        $result = preg_match($this->pattern, $value);
        $result = (bool) $result;

        if ($result) {
            return true;
        }

        $this->addError(self::NO_MATCH_FOUND);

        return false;
    }
}
