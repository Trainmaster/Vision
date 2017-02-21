<?php
declare(strict_types = 1);

namespace Vision\DependencyInjection;

class Definition
{
    /** @var mixed $class */
    private $class;

    /** @var bool $shared */
    private $shared = true;

    /** @var array $factory */
    private $factory = [];

    /** @var array $property */
    private $property = [];

    /** @var array $constructor */
    private $constructor = [];

    /** @var array $method */
    private $method = [];

    public function __construct(string $class)
    {
        $this->class = $class;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function setShared(bool $shared): Definition
    {
        $this->shared = $shared;
        return $this;
    }

    public function isShared(): bool
    {
        return $this->shared;
    }

    public function property(string $property, $value): Definition
    {
        $this->property[$property] = $value;
        return $this;
    }

    public function constructor(array $constructor): Definition
    {
        $this->constructor = $constructor;
        return $this;
    }

    public function method(string $method, array $dependencies): Definition
    {
        $this->method[][$method] = $dependencies;
        return $this;
    }

    public function factory(string $dependency, string $method, array $args = []): Definition
    {
        $this->factory = [$dependency, $method, $args];
        return $this;
    }

    public function getFactory(): array
    {
        return $this->factory;
    }

    public function hasFactory(): bool
    {
        return !empty($this->factory);
    }

    public function setMethod(array $method): Definition
    {
        $this->method = $method;
        return $this;
    }

    public function getPropertyInjections(): array
    {
        return $this->property;
    }

    public function getConstructorInjections(): array
    {
        return $this->constructor;
    }

    public function getMethodInjections(): array
    {
        return $this->method;
    }
}
