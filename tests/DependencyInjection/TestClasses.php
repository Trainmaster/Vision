<?php
class BasicClass
{
}

class DependentClass
{
    public function __construct(BasicClass $basicClass)
    {
        $this->basicClass = $basicClass;
    }

    public function getBasicClass()
    {
        return $this->basicClass;
    }
}
