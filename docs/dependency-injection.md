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