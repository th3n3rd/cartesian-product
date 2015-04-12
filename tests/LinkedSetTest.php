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
 * Class LinkedSetTest.
 *
 * @package   Nerd\CartesianProduct
 * @author    Marco Garofalo <marcogarofalo.personal@gmail.com>
 */
class LinkedSetTest extends PHPUnit_Framework_TestCase
{
    private static $values = array('a', 'b');

    /**
     * @test
     */
    public function shouldComputeTheCurrentElementForBothArrayAndNonArrayValues()
    {
        $set = $this->getSet();
        $nonArrayValue = 'test';
        $set->expects($this->exactly(2))
            ->method('current')
            ->will($this->returnValue($nonArrayValue));

        $linkedSet = new LinkedSet($set, self::$values);
        $this->assertEquals(array('a', 'test'), $linkedSet->current());
        $linkedSet->next();
        $this->assertEquals(array('b', 'test'), $linkedSet->current());


        $set = $this->getSet();
        $arrayValue = array('test');
        $set->expects($this->exactly(2))
            ->method('current')
            ->will($this->returnValue($arrayValue));

        $linkedSet = new LinkedSet($set, self::$values);
        $this->assertEquals(array('a', 'test'), $linkedSet->current());
        $linkedSet->next();
        $this->assertEquals(array('b', 'test'), $linkedSet->current());
    }

    /**
     * @test
     */
    public function shouldMoveToTheCursorToNextElementOnlyWhenNeighbourIsInvalid()
    {
        $set = $this->getSet();
        $set->expects($this->at(0))
            ->method('next');
        $set->expects($this->at(1))
            ->method('valid')
            ->will($this->returnValue(false));
        $set->expects($this->at(2))
            ->method('rewind');

        $linkedSet = new LinkedSet($set, self::$values);
        $this->assertEquals(0, $linkedSet->key());
        $linkedSet->next();
        $this->assertEquals(1, $linkedSet->key());

        $set = $this->getSet();
        $set->expects($this->at(0))
            ->method('next');
        $set->expects($this->at(1))
            ->method('valid')
            ->will($this->returnValue(true));

        $linkedSet = new LinkedSet($set, self::$values);
        $this->assertEquals(0, $linkedSet->key());
        $linkedSet->next();
        $this->assertEquals(0, $linkedSet->key());
    }


    /**
     * @test
     */
    public function shouldReturnTheCurrentCursor()
    {
        $set = $this->getSet();
        $linkedSet = new LinkedSet($set, self::$values);
        $this->assertEquals(0, $linkedSet->key());
        $linkedSet->next();
        $this->assertEquals(1, $linkedSet->key());
    }

    /**
     * @test
     */
    public function shouldDetectAnInvalidCursor()
    {
        $set = $this->getSet();
        $linkedSet = new LinkedSet($set, self::$values);
        $this->assertTrue($linkedSet->valid());
        $linkedSet->next();
        $this->assertTrue($linkedSet->valid());
        $linkedSet->next();
        $this->assertFalse($linkedSet->valid());
    }

    /**
     * @test
     */
    public function shouldAllowToResetTheState()
    {
        $set = $this->getSet();
        $linkedSet = new LinkedSet($set, self::$values);
        $this->assertEquals(0, $linkedSet->key());
        $linkedSet->next();
        $this->assertEquals(1, $linkedSet->key());
        $linkedSet->rewind();
        $this->assertEquals(0, $linkedSet->key());
    }

    private function getSet()
    {
        $set = $this->getMockBuilder('Nerd\\CartesianProduct\\Set')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        return $set;
    }
}