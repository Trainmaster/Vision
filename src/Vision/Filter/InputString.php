<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Filter;

class InputString implements FilterInterface
{
    protected $options = [];

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function filter($value)
    {
        return filter_var($value, FILTER_SANITIZE_STRING, $this->getOptions());
    }
}
