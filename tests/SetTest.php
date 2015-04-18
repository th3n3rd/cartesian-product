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
 * Class SetTest.
 *
 * @package   Nerd\CartesianProduct
 * @author    Marco Garofalo <marcogarofalo.personal@gmail.com>
 */
class SetTest extends PHPUnit_Framework_TestCase
{
    private static $values = array('a', 'b', 'c');

    /**
     * @var Set
     */
    private $set;

    public function setUp()
    {
        $this->set = new Set(self::$values);
    }

    /**
     * @test
     */
    public function shouldBeAbleToComputeTheCurrentElement()
    {
        $this->assertEquals('a', $this->set->current());
    }

    /**
     * @test
     */
    public function shouldAllowToMoveAndTrackTheCursor()
    {
        $this->assertEquals(0, $this->set->key());
        $this->set->next();
        $this->assertEquals(1, $this->set->key());
        $this->set->next();
        $this->assertEquals(2, $this->set->key());
        $this->set->rewind();
        $this->assertEquals(0, $this->set->key());
    }

    /**
     * @test
     */
    public function shouldDetectAnInvalidCursor()
    {
        $this->assertTrue($this->set->valid());
        $this->set->next();
        $this->assertTrue($this->set->valid());
        $this->set->next();
        $this->assertTrue($this->set->valid());
        $this->set->next();
        $this->assertFalse($this->set->valid());
    }
}