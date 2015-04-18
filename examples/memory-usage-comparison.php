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
    // nothing
}
$bench->end();
$iteratorUseCaseBytes = $bench->getMemoryUsage(true);
$iteratorUseCase = $bench->getMemoryUsage();

$bench->start();
$wholeResult = $cartesianProduct->compute();
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