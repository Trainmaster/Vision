# Cache

The cache currently ships with a file-based caching mechanism. More to come.

## Usage
```php
use Vision\Cache;
use Vision\Cache\Adapter\File;

$options = array(
    'encoding' => File::ENC_JSON,
    'cache_dir' => __DIR__ . '/cache'
);

$adapter = new File($options);
$cache = new Cache($adapter);

$cache->set('foo', 'bar');
$cache->get('foo');
```