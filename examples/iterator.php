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

$bench->start();
foreach ($cartesianProduct as $index => $product) {
    printf("[%s] (%s)\n", $index, implode(',', $product));
}
$bench->end();

printf("Time elapsed: %s\n", $bench->getTime());
printf("Memory footprint: %s\n", $bench->getMemoryPeak());