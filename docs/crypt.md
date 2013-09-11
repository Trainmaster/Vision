# Crypt

<!-- Description -->

## Usage

```php
$random = new Vision\Crypt\Random;

$salt = $random->generateBytes(16);

$bcrypt = new Vision\Crypt\Bcrypt;
$hash = $bcrypt->hash('foo', 12, $salt);

var_dump($bcrypt->verify('foo', $hash));
// bool(true)

var_dump($bcrypt->verify('bar', $hash));
// bool(false)
```