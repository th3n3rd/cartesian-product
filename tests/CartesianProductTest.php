<?php

/**
 * This file is part of the Cartesian Product package.
 *
 * (c) Marco Garofalo <marcogarofalo.personal@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nerd\CartesianProduct;

use PHPUnit\Framework\TestCase;

/**
 * @author Marco Garofalo <marcogarofalo.personal@gmail.com>
 */
class CartesianProductTest extends TestCase
{
    public function testShouldBeAbleToHandleAnEmptyProduct()
    {
        $cartesianProduct = CartesianProduct::empty();

        $this->assertEquals([], $this->computeIteratively($cartesianProduct));
        $this->assertEquals([], $cartesianProduct->compute());
    }

    public function testShouldBeAbleToHandleASingleSet()
    {
        $cartesianProduct = CartesianProduct::empty()->appendSet(['a', 'b']);
        $expectedProduct = [
            ['a'],
            ['b'],
        ];

        $this->assertEquals($expectedProduct, $this->computeIteratively($cartesianProduct));
        $this->assertEquals($expectedProduct, $cartesianProduct->compute());
    }

    public function testShouldBeAbleToHandleMultipleSets()
    {
        $cartesianProduct = CartesianProduct::empty()
            ->appendSet(['a', 'b'])
            ->appendSet(['c', 'd']);
        $expectedProduct = [
            ['a', 'c'],
            ['a', 'd'],
            ['b', 'c'],
            ['b', 'd'],
        ];

        $this->assertEquals($expectedProduct, $this->computeIteratively($cartesianProduct));
        $this->assertEquals($expectedProduct, $cartesianProduct->compute());
    }

    public function testShouldAllowToMoveAndTrackTheCursor()
    {
        $cartesianProduct = CartesianProduct::empty();

        $this->assertEquals(0, $cartesianProduct->key());

        $cartesianProduct->next();
        $this->assertEquals(1, $cartesianProduct->key());

        $cartesianProduct->next();
        $this->assertEquals(2, $cartesianProduct->key());

        $cartesianProduct->next();
        $this->assertEquals(3, $cartesianProduct->key());

        $cartesianProduct->rewind();
        $this->assertEquals(0, $cartesianProduct->key());
    }

    public function testShouldDetectAnInvalidCursor() {
        $emptyProduct = CartesianProduct::empty();
        $oneSetProduct = CartesianProduct::empty()->appendSet(['a']);

        $this->assertFalse($emptyProduct->valid());
        $this->assertTrue($oneSetProduct->valid());

        $emptyProduct->next();
        $oneSetProduct->next();
        $this->assertFalse($emptyProduct->valid());
        $this->assertFalse($emptyProduct->valid());
    }


    private function computeIteratively(CartesianProduct $cartesianProduct): array
    {
        $actual = [];
        foreach ($cartesianProduct as $product) {
            $actual[] = $product;
        }
        return $actual;
    }
}
