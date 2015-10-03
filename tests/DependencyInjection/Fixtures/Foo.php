<?php
namespace VisionTest\DependencyInjection\Fixtures;

class Foo
{
    public $param1;

    public function __construct($param1 = null) {
        $this->param1 = $param1;
    }
}
