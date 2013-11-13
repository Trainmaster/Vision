# Dependency Injection

## Usage

### Simple example

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

$container->register('Foo');
$container->register('Bar')->constructor('@Foo'));

$bar = $container->get('Bar');
```

### Interface injection
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

$container->register('Foo');
$container->register('FooInterface')->method('setFoo', '@Foo'));
$container->register('Bar');

$bar = $container->get('Bar');
```