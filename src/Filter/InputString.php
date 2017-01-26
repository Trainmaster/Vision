<?php
namespace Vision\Filter;

class InputString implements Filter
{
    private $options = [];

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
