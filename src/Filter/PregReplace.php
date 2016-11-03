<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
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
