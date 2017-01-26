<?php
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
