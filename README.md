# Cartesian Product

[![Latest Version](https://img.shields.io/github/release/th3n3rd/cartesian-product.svg?style=flat-square)](https://github.com/th3n3rd/cartesian-product/releases)
[![Build Status](https://github.com/th3n3rd/cartesian-product/actions/workflows/ci.yml/badge.svg)](https://github.com/th3n3rd/cartesian-product/actions/workflows/ci.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/th3n3rd/cartesian-product.svg?style=flat-square)](https://packagist.org/packages/th3n3rd/cartesian-product)

**Memory efficient Cartesian Product implementation.**

It uses iterators in order to store only a specific tuple at a time, being able to compute even large combinations
without affecting the memory footprint.

## Install

Via Composer

``` bash
$ composer require th3n3rd/cartesian-product
```

## Usage

The library can be used as an iterator:

```php
use Nerd\CartesianProduct\CartesianProduct;

$cartesianProduct = new CartesianProduct();

$cartesianProduct
    ->appendSet(['a', 'b', 'c'])
    ->appendSet(['d', 'e'])
;

foreach ($cartesianProduct as $index => $product) {
    printf("[%s] (%s)\n", $index, implode(',', $product));
}
```

Or you can compute the whole result at once (not recommended for large sets):

```php
$result = $cartesianProduct->compute();
```


## Testing

``` bash
$ vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
