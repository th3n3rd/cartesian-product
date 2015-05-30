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

/**
 * @author Marco Garofalo <marcogarofalo.personal@gmail.com>
 */
class CartesianProductTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CartesianProduct
     */
    private $cartesianProduct;

    /**
     * @var array
     */
    private static $sets = array(
        array('a', 'b'),
        array('c', 'd')
    );

    public function setUp()
    {
        $this->cartesianProduct = new CartesianProduct(self::$sets);
    }

    public function testShouldBeAbleToHandleASingleSet()
    {
        $singleSet = array(array('a', 'b'));
        $cartesianProduct = new CartesianProduct($singleSet);

        $this->assertTrue(is_array($cartesianProduct->current()));
        $cartesianProduct->next();
        $this->assertTrue(is_array($cartesianProduct->current()));
    }

    public function testShouldComputeTheCartesianProductIterativelyAndAsWholeCorrectly()
    {
        $expectedProduct = array(
            array('a', 'c'),
            array('a', 'd'),
            array('b', 'c'),
            array('b', 'd'),
        );

        // using the iterator interface
        $actualProductIteratively = array();
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
        $this->assertEquals(array('a', 'c'), $this->cartesianProduct->current());
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
