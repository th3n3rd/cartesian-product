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
    // nothing
}
$bench->end();
$iteratorUseCaseBytes = $bench->getMemoryUsage(true);
$iteratorUseCase = $bench->getMemoryUsage();

$bench->start();
$wholeResult = $cartesianProduct->toArray();
foreach ($wholeResult as $index => $product) {
    // nothing
}
$bench->end();
$wholeUseCaseBytes = $bench->getMemoryUsage(true);
$wholeUseCase = $bench->getMemoryUsage();
unset($wholeResult);

printf("Memory Usage Comparison: \n");
printf("Whole -> %s\n", $wholeUseCase);
printf("Iterator -> %s\n", $iteratorUseCase);
printf("Ratio: 1:%s (whole vs iterator) \n", ceil($iteratorUseCaseBytes / $wholeUseCaseBytes * 100));
