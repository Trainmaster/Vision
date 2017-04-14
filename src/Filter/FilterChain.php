<?php
declare(strict_types = 1);

namespace Vision\Filter;

class FilterChain implements Filter
{
    /** @var Filter[] */
    private $filters = [];

    public function add(Filter $filter): self
    {
        $this->filters[] = $filter;
        return $this;
    }

    public function filter($value)
    {
        foreach ($this->filters as $filter) {
            $value = $filter->filter($value);
        }

        return $value;
    }
}
