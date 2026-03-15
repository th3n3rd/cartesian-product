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
    private static array $sets = [
        ['a', 'b'],
        ['c', 'd']
    ];
    private CartesianProduct $cartesianProduct;

    protected function setUp(): void
    {
        $this->cartesianProduct = CartesianProduct::of(self::$sets);
    }

    public function testShouldBeAbleToHandleASingleSet()
    {
        $singleSet = [['a', 'b']];
        $cartesianProduct = CartesianProduct::of($singleSet);

        $this->assertIsArray($cartesianProduct->current());
        $cartesianProduct->next();
        $this->assertIsArray($cartesianProduct->current());
    }

    public function testShouldBeAbleToCreateAnEmptyProduct()
    {
        $cartesianProduct = CartesianProduct::empty();

        $this->assertFalse($cartesianProduct->valid());
        $this->assertEquals([], $cartesianProduct->compute());
        $this->assertEquals([], $cartesianProduct->current());
    }

    public function testShouldComputeTheCartesianProductIterativelyAndAsWholeCorrectly()
    {
        $expectedProduct = [
            ['a', 'c'],
            ['a', 'd'],
            ['b', 'c'],
            ['b', 'd'],
        ];

        // using the iterator interface
        $actualProductIteratively = [];
        foreach ($this->cartesianProduct as $product) {
            $actualProductIteratively[] = $product;
        }

        // using the compute method
        $actualProductAsWhole = $this->cartesianProduct->compute();

        $this->assertEquals($actualProductAsWhole, $actualProductIteratively);
        $this->assertEquals($expectedProduct, $actualProductIteratively);
        $this->assertEquals($expectedProduct, $actualProductAsWhole);
    }

    public function testShouldBeAbleToComputeTheCurrentElement()
    {
        $this->assertEquals(['a', 'c'], $this->cartesianProduct->current());
    }

    public function testShouldAllowToMoveAndTrackTheCursor()
    {
        $this->assertEquals(0, $this->cartesianProduct->key());
        $this->cartesianProduct->next();
        $this->assertEquals(1, $this->cartesianProduct->key());
        $this->cartesianProduct->next();
        $this->assertEquals(2, $this->cartesianProduct->key());
        $this->cartesianProduct->rewind();
        $this->assertEquals(0, $this->cartesianProduct->key());
    }

    public function testShouldDetectAnInvalidCursor()
    {
        $this->assertTrue($this->cartesianProduct->valid());
        $this->cartesianProduct->next();
        $this->assertTrue($this->cartesianProduct->valid());
        $this->cartesianProduct->next();
        $this->assertTrue($this->cartesianProduct->valid());
        $this->cartesianProduct->next();
        $this->assertTrue($this->cartesianProduct->valid());
        $this->cartesianProduct->next();
        $this->assertFalse($this->cartesianProduct->valid());
    }
}
