<?php
/**
 * This file is part of Cartesian Product.
 *
 * (c) Marco Garofalo <marcogarofalo.personal@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Nerd\CartesianProduct\CartesianProduct;

require __DIR__ . '/../vendor/autoload.php';

$bench = new Ubench();

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

$bench->start();
foreach ($cartesianProduct as $index => $product) {
    printf("[%s] (%s)\n", $index, implode(',', $product));
}
$bench->end();

printf("Time elapsed: %s\n", $bench->getTime());
printf("Memory footprint: %s\n", $bench->getMemoryPeak());
