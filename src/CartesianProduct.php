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

use InvalidArgumentException;
use Iterator;

/**
 * @author Marco Garofalo <marcogarofalo.personal@gmail.com>
 */
class CartesianProduct implements Iterator
{
    private int $cursor = 0;
    private array $sets = [];
    private Iterator $referenceSet;

    public function __construct(iterable $sets = [])
    {
        foreach ($sets as $set) {
            $this->addSet($set);
        }

        $this->computeReferenceSet();
    }

    /**
     * Adds a set.
     *
     * @param iterable $set
     *
     * @throws InvalidArgumentException
     */
    private function addSet(iterable $set): void
    {
        if (is_array($set)) {
            $set = new \ArrayIterator($set);
        } elseif ($set instanceof \Traversable) {
            $set = new \IteratorIterator($set);
        } else {
            throw new InvalidArgumentException('Set must be either an array or Traversable');
        }

        $this->sets[] = $set;
    }

    /**
     * Appends the given set.
     *
     * @param iterable $set
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function appendSet(iterable $set): self
    {
        $this->addSet($set);
        $this->computeReferenceSet();

        return $this;
    }

    /**
     * Computes the reference set used for iterate over the product.
     */
    private function computeReferenceSet(): void
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
    public function current(): array
    {
        $current = $this->referenceSet->current();

        return !is_array($current) ? [$current] : $current;
    }

    /**
     * {@inheritdoc}
     */
    public function next(): void
    {
        $this->cursor++;
        $this->referenceSet->next();
    }

    /**
     * {@inheritdoc}
     */
    public function key(): int
    {
        return $this->cursor;
    }

    /**
     * {@inheritdoc}
     */
    public function valid(): bool
    {
        return $this->referenceSet->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
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
    public function compute(): array
    {
        $product = [];

        $this->referenceSet->rewind();

        while ($this->referenceSet->valid()) {
            $product[] = $this->referenceSet->current();
            $this->referenceSet->next();
        }

        return $product;
    }
}
