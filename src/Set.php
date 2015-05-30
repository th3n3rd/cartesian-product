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
class Set extends \IteratorIterator
{
    /**
     * @var \Iterator
     */
    private $neighbour;

    /**
     * @param \Iterator $set
     * @param \Iterator $neighbour
     */
    public function __construct(\Iterator $set, \Iterator $neighbour)
    {
        $this->neighbour = $neighbour;

        parent::__construct($set);
        parent::rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        $neighbourCurrent = $this->neighbour->current();
        $current = parent::current();

        if (!is_array($neighbourCurrent)) {
            $neighbourCurrent = array($neighbourCurrent);
        }

        if (!is_array($current)) {
            $current = array($current);
        }

        return array_merge($current, $neighbourCurrent);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->neighbour->next();

        if (!$this->neighbour->valid()) {
            $this->neighbour->rewind();
            parent::next();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->neighbour->rewind();
        parent::rewind();
    }
}
