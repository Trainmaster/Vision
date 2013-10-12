# Autoload

The usage is straightforward, the directory structure is exemplary.

`app/acme/config/autoload.php`
```php
require_once 'path/to/Vision/src/Vision/Autoload/SplClassLoader.php';

$classAutoloader = new \Vision\Autoload\SplClassLoader('Vision', '../../lib/Vision/src');
$classAutoloader->register();

$classAutoloader = new \Vision\Autoload\SplClassLoader('Twig', '../../lib');
$classAutoloader->setNamespaceSeparator('_');
$classAutoloader->register();

$classAutoloader = new \Vision\Autoload\SplClassLoader('Zend', '../../lib/zf2/library');
$classAutoloader->register();

$classAutoloader = new \Vision\Autoload\SplClassLoader('acme', '../../app');
$classAutoloader->register();
```

As you can see, it is very easy to integrate third-party libraries like [ZF2](http://framework.zend.com) or [Twig](http://twig.sensiolabs.org).