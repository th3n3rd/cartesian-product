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

use Iterator;
use IteratorIterator;

/**
 * @author Marco Garofalo <marcogarofalo.personal@gmail.com>
 */
class Set extends IteratorIterator
{
    private Iterator $neighbour;

    public function __construct(Iterator $set, Iterator $neighbour)
    {
        $this->neighbour = $neighbour;
        parent::__construct($set);
        parent::rewind();
    }

    public function current(): mixed
    {
        $neighbourCurrent = $this->neighbour->current();
        $current = parent::current();

        if (!$this->neighbour instanceof self) {
            $neighbourCurrent = [$neighbourCurrent];
        }

        array_unshift($neighbourCurrent, $current);

        return $neighbourCurrent;
    }

    public function next(): void
    {
        $this->neighbour->next();

        if (!$this->neighbour->valid()) {
            $this->neighbour->rewind();
            parent::next();
        }
    }

    public function rewind(): void
    {
        $this->neighbour->rewind();
        parent::rewind();
    }
}
