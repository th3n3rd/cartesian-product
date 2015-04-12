### Cartesian Product

This is a memory efficient Cartesian Product implementation.
It uses iterators in order to store only a specific tuple at time being able to compute every large combinations
without affecting the memory footprint.

## Install

The best way to install Tree is [through composer](http://getcomposer.org).

Just create a composer.json file for your project:

```JSON
{
    "require": {
        "th3n3rd/cartesian-product": "0.1"
    }
}
```

Then you can run these two commands to install it:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install

or simply run `composer install` if you have have already [installed the composer globally](http://getcomposer.org/doc/00-intro.md#globally).

Then you can include the autoloader, and you will have access to the library classes:

```php
<?php
require __DIR__ . '/vendor/autoload.php';
```

# Tests
```
phpunit
```

