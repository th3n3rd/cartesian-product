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
class SetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private static $values = array('a', 'b');

    public function testShouldComputeTheCurrentElementForBothArrayAndNonArrayValues()
    {
        $neighbour = $this->getNeighbour();
        $nonArrayValue = 'test';
        $neighbour->expects($this->exactly(2))
            ->method('current')
            ->will($this->returnValue($nonArrayValue));

        $set = new Set(new \ArrayIterator(self::$values), $neighbour);
        $this->assertEquals(array('a', 'test'), $set->current());
        $set->next();
        $this->assertEquals(array('b', 'test'), $set->current());


        $neighbour = $this->getNeighbour();
        $arrayValue = array('test');
        $neighbour->expects($this->exactly(2))
            ->method('current')
            ->will($this->returnValue($arrayValue));

        $set = new Set(new \ArrayIterator(self::$values), $neighbour);
        $this->assertEquals(array('a', 'test'), $set->current());
        $set->next();
        $this->assertEquals(array('b', 'test'), $set->current());
    }

    public function testShouldMoveToTheCursorToNextElementOnlyWhenNeighbourIsInvalid()
    {
        $neighbour = $this->getNeighbour();
        $neighbour->expects($this->at(0))
            ->method('next');
        $neighbour->expects($this->at(1))
            ->method('valid')
            ->will($this->returnValue(false));
        $neighbour->expects($this->at(2))
            ->method('rewind');

        $set = new Set(new \ArrayIterator(self::$values), $neighbour);
        $this->assertEquals(0, $set->key());
        $set->next();
        $this->assertEquals(1, $set->key());

        $neighbour = $this->getNeighbour();
        $neighbour->expects($this->at(0))
            ->method('next');
        $neighbour->expects($this->at(1))
            ->method('valid')
            ->will($this->returnValue(true));

        $set = new Set(new \ArrayIterator(self::$values), $neighbour);
        $this->assertEquals(0, $set->key());
        $set->next();
        $this->assertEquals(0, $set->key());
    }


    public function testShouldAllowToMoveAndTrackTheCursor()
    {
        $neighbour = $this->getNeighbour();

        $neighbour->expects($this->exactly(1))
            ->method('valid')
            ->will($this->returnValue(false));

        $neighbour->expects($this->exactly(2))
            ->method('rewind');

        $set = new Set(new \ArrayIterator(self::$values), $neighbour);
        $this->assertEquals(0, $set->key());
        $set->next();
        $this->assertEquals(1, $set->key());
        $set->rewind();
        $this->assertEquals(0, $set->key());
    }

    public function testShouldDetectAnInvalidCursor()
    {
        $neighbour = $this->getNeighbour();
        $set = new Set(new \ArrayIterator(self::$values), $neighbour);
        $this->assertTrue($set->valid());
        $set->next();
        $this->assertTrue($set->valid());
        $set->next();
        $this->assertFalse($set->valid());
    }

    private function getNeighbour()
    {
        return $this->getMockBuilder('Iterator')
            ->disableOriginalConstructor()
            ->getMock();
    }
}