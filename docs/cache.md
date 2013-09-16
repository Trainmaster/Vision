# Cache

The cache currently ships with a file-based caching storage. More to come.


## Storage
* `Vision\Cache\Storage\File`: File-based

## Usage
```php
use Vision\Cache;
use Vision\Cache\Storage\File as FileStorage;

$options = array(
    'encoding' => File::ENC_JSON,
    'cache_dir' => __DIR__ . '/cache'
);

$storage = new FileStorage($options);
$cache = new Cache($storage);

$cache->set('foo', 'bar', 10);
var_dump ($cache->get('foo'));
// string(3) "bar"

sleep(15);

var_dump ($cache->get('foo'));
// NULL
```