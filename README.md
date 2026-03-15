# Cartesian Product

[![Latest Version](https://img.shields.io/github/release/th3n3rd/cartesian-product.svg?style=flat-square)](https://github.com/th3n3rd/cartesian-product/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/th3n3rd/cartesian-product.svg?style=flat-square)](https://travis-ci.org/th3n3rd/cartesian-product)
[![HHVM Status](https://img.shields.io/hhvm/th3n3rd/cartesian-product.svg?style=flat-square)](http://hhvm.h4cc.de/package/th3n3rd/cartesian-product)
[![Total Downloads](https://img.shields.io/packagist/dt/th3n3rd/cartesian-product.svg?style=flat-square)](https://packagist.org/packages/th3n3rd/cartesian-product)

**Memory efficient Cartesian Product implementation.**

It uses iterators in order to store only a specific tuple at time being able to compute even large combinations
without affecting the memory footprint.

## Install

Via Composer

``` bash
$ composer require th3n3rd/cartesian-product
```

## Usage

```php

use Nerd\CartesianProduct\CartesianProduct;

$cartesianProduct = new CartesianProduct();

$cartesianProduct
    ->appendSet(['a', 'b', 'c'])
    ->appendSet(['d', 'e'])
    ->appendSet(['f', 'g', 'h'])
    ->appendSet(['i', 'j'])
    ->appendSet(['k', 'l'])
    ->appendSet(['m', 'n'])
    ->appendSet(['o'])
    ->appendSet(['p'])
    ->appendSet(['q', 'r', 's', 't'])
    ->appendSet(['u', 'v', 'w'])
    ->appendSet(['x', 'y'])
    ->appendSet(['z'])
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


## Testing

``` bash
$ phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
