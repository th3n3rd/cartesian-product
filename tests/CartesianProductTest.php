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
    /**
     * @var CartesianProduct
     */
    private $cartesianProduct;

    private static $sets = array(
        array('a', 'b'),
        array('c', 'd')
    );

    public function setUp()
    {
        $this->cartesianProduct = new CartesianProduct(self::$sets);
    }

    public function shouldBeAbleToHandleASingleSet()
    {
        $singleSet = array(array('a', 'b'));
        $cartesianProduct = new CartesianProduct($singleSet);

        $this->assertTrue(is_array($cartesianProduct->current()));
        $cartesianProduct->next();
        $this->assertTrue(is_array($cartesianProduct->current()));
    }

    /**
     * @test
     */
    public function shouldComputeTheCartesianProductIterativelyAndAsWholeCorrectly()
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

    /**
     * @test
     */
    public function shouldBeAbleToComputeTheCurrentElement()
    {
        $this->assertEquals(array('a', 'c'), $this->cartesianProduct->current());
    }

    /**
     * @test
     */
    public function shouldAllowToMoveAndTrackTheCursor()
    {
        $this->assertEquals(0, $this->cartesianProduct->key());
        $this->cartesianProduct->next();
        $this->assertEquals(1, $this->cartesianProduct->key());
        $this->cartesianProduct->next();
        $this->assertEquals(2, $this->cartesianProduct->key());
        $this->cartesianProduct->rewind();
        $this->assertEquals(0, $this->cartesianProduct->key());
    }

    /**
     * @test
     */
    public function shouldDetectAnInvalidCursor()
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