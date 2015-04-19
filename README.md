# Cartesian Product [![Build Status](https://travis-ci.org/th3n3rd/cartesian-product.svg)](https://travis-ci.org/th3n3rd/cartesian-product)

This is a memory efficient Cartesian Product implementation.
It uses iterators in order to store only a specific tuple at time being able to compute even large combinations
without affecting the memory footprint.

## Usage

```php

require __DIR__ . '/../vendor/autoload.php';

use Nerd\CartesianProduct\CartesianProduct;

$cartesianProduct = new CartesianProduct();

$cartesianProduct
    ->appendSet(array('a', 'b', 'c'))
    ->appendSet(array('d', 'e'))
    ->appendSet(array('f', 'g', 'h'))
    ->appendSet(array('i', 'j'))
    ->appendSet(array('k', 'l'))
    ->appendSet(array('m', 'n'))
    ->appendSet(array('o'))
    ->appendSet(array('p'))
    ->appendSet(array('q', 'r', 's', 't'))
    ->appendSet(array('u', 'v', 'w'))
    ->appendSet(array('x', 'y'))
    ->appendSet(array('z'))
;

foreach ($cartesianProduct as $index => $product) {
    printf("[%s] (%s)\n", $index, implode(',', $product));
}

// or (not recommended)
$result = $cartesianProduct->compute();

foreach ($result as $index => $product) {
    printf("[%s] (%s)\n", $index, implode(',', $product));
}
```

## Install

The best way to install CartesianProduct is [through composer](http://getcomposer.org).

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

## Tests
```
phpunit
```

