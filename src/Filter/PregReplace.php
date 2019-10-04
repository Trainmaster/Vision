<?php

declare(strict_types=1);

namespace Vision\Filter;

class PregReplace implements Filter
{
    /** @var string|string[] */
    private $pattern;

    /** @var string|\string[] */
    private $replacement;

    /**
     * @param string|string[] $pattern
     * @param string|string[] $replacement
     */
    public function __construct($pattern, $replacement)
    {
        $this->pattern = $pattern;
        $this->replacement = $replacement;
    }

    /**
     * @link http://php.net/manual/de/function.preg-replace.php
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function filter($value)
    {
        return preg_replace($this->pattern, $this->replacement, $value);
    }
}
