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
class CartesianProduct implements \Iterator
{
    /**
     * @var array
     */
    private $sets = array();

    /**
     * @var \Iterator
     */
    private $referenceSet;

    /**
     * @var integer
     */
    private $cursor = 0;

    /**
     * @param array $sets
     */
    public function __construct(array $sets = array())
    {
        foreach ($sets as $set) {
            $this->addSet($set);
        }

        $this->computeReferenceSet();
    }

    /**
     * Adds a set.
     *
     * @param array|Traversable $set
     *
     * @throws \InvalidArgumentException
     */
    private function addSet($set)
    {
        if (is_array($set)) {
            $set = new \ArrayIterator($set);
        } elseif ($set instanceof \Traversable) {
            $set = new \IteratorIterator($set);
        } else {
            throw new \InvalidArgumentException('Set must be either an array or Traversable');
        }

        $this->sets[] = $set;
    }

    /**
     * Appends the given set.
     *
     * @param array|Traversable $set
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function appendSet($set)
    {
        $this->addSet($set);
        $this->computeReferenceSet();

        return $this;
    }

    /**
     * Computes the reference set used for iterate over the product.
     */
    private function computeReferenceSet()
    {
        if (empty($this->sets)) {
            return;
        }

        $sets = array_reverse($this->sets);
        $this->referenceSet = array_shift($sets);

        foreach ($sets as $set) {
            $this->referenceSet = new Set($set, $this->referenceSet);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        $current = $this->referenceSet->current();

        return !is_array($current) ? array($current) : $current;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->cursor++;
        $this->referenceSet->next();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->cursor;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->referenceSet->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->cursor = 0;
        $this->referenceSet->rewind();
    }

    /**
     * Computes the product and return the whole result.
     *
     * This method is recommended only when the result is relatively small.
     *
     * The recommended way to use the Cartesian Product is through its iterator interface
     * which is memory efficient.
     */
    public function compute()
    {
        $product = array();

        $this->referenceSet->rewind();

        while ($this->referenceSet->valid()) {
            $product[] = $this->referenceSet->current();
            $this->referenceSet->next();
        }

        return $product;
    }
}
