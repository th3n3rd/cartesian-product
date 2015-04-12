<?php
/**
 * This file is part of Cartesian Product.
 *
 * (c) Marco Garofalo <marcogarofalo.personal@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nerd\CartesianProduct;

use PHPUnit_Framework_TestCase;

/**
 * Class CartesianProductTest.
 *
 * @package   Nerd\CartesianProduct
 * @author    Marco Garofalo <marcogarofalo.personal@gmail.com>
 */
class CartesianProductTest extends PHPUnit_Framework_TestCase
{
    private static $sets = array(
        array('a', 'b'),
        array('c', 'd')
    );

    /**
     * @test
     */
    public function shouldComputeTheCartesianProductCorrectly()
    {
        $cartesianProduct = new CartesianProduct(self::$sets);

        $expectedProduct = array(
            array('a', 'c'),
            array('a', 'd'),
            array('b', 'c'),
            array('b', 'd'),
        );

        // using the iterator interface
        $actualProductIteratively = array();
        foreach ($cartesianProduct as $product) {
            $actualProductIteratively[] = $product;
        }

        // using the compute method
        $actualProductAsWhole = $cartesianProduct->compute();

        $this->assertEquals($actualProductAsWhole, $actualProductIteratively);
        $this->assertEquals($expectedProduct, $actualProductIteratively);
        $this->assertEquals($expectedProduct, $actualProductAsWhole);
    }
}