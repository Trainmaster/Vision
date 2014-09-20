<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Filter;

/**
 * FilterChain
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class FilterChain implements FilterInterface
{
    /**
     * @type array
     */
    protected $filters = array();

    /**
     * @param FilterInterface $filter
     *
     * @return FilterChain
     */
    public function add(FilterInterface $filter)
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
