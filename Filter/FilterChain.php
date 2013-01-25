<?php
namespace Vision\Filter;

class FilterChain implements FilterInterface
{
    protected $filters = array();
    
    public function add(FilterInterface $filter)
    {
        $this->filters[] = $filter;
        return $this;
    }
    
    public function filter($value)
    {
        foreach ($this->filters as $filter) {
            $value = $filter($value);
        }
        return $value;
    }
}