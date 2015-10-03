<?php
namespace VisionTest\DependencyInjection\Fixtures;

class FooFactory
{
    public function getInstance()
    {
        return new Foo;
    }

    public function getInstanceWithParameters($param1) {
        return new Foo($param1);
    }
}
