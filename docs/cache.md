# Cache

The cache currently ships with a file-based caching adapter. More to come.


## Adapter
* ´Vision\Cache\Adapter\File`: File-based

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