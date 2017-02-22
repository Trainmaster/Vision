# Dependency Injection

## Usage

### Constructor injection

```php
use Vision\DependencyInjection\Container;

class Foo
{}

class Bar
{
    public function __construct(Foo $foo)
    {
        $this->foo = $foo;
    }
}

$container = new Container;

$container->register(Foo::class);
$container->register(Bar::class)->constructor('@Foo'));

$bar = $container->get(Bar::class);
```

### Interface injection

```php
use Vision\DependencyInjection\Container;

class Foo
{}

interface FooInterface
{
    public function setFoo(Foo $foo);
    public function getFoo();
}

class Bar implements FooInterface
{
    protected $foo = null;
    
    public function setFoo(Foo $foo)
    {
        $this->foo = foo;
    }
    
    public function getFoo()
    {
        return $this->foo;
    }
}

$container = new Container;

$container->register(Foo::class);
$container->register(FooInterface::class)->method('setFoo', '@Foo'));
$container->register(Bar::class);

$bar = $container->get(Bar::class);
```
