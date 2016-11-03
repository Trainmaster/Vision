<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Filter;

class FilterChain implements Filter
{
    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @param Filter $filter
     *
     * @return FilterChain
     */
    public function add(Filter $filter)
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function filter($value)
    {
        foreach ($this->filters as $filter) {
            $value = $filter($value);
        }

        return $value;
    }
}
