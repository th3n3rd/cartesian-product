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

$cartesianProduct = CartesianProduct::empty()
    ->with(['a', 'b', 'c'])
    ->with(['d', 'e'])
    ->with(['f', 'g', 'h'])
    ->with(['i', 'j'])
    ->with(['k', 'l'])
    ->with(['m', 'n'])
    ->with(['o'])
    ->with(['p'])
    ->with(['q', 'r', 's', 't'])
    ->with(['u', 'v', 'w'])
    ->with(['x', 'y'])
    ->with(['z'])
;

$bench->start();
foreach ($cartesianProduct as $index => $product) {
    printf("[%s] (%s)\n", $index, implode(',', $product));
}
$bench->end();

printf("Time elapsed: %s\n", $bench->getTime());
printf("Memory footprint: %s\n", $bench->getMemoryPeak());
