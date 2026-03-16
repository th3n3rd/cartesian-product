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

    private function __construct()
    {
        $this->referenceSet = new \EmptyIterator();
    }

    /**
     * Returns a new instance.
     *
     * @param iterable $sets
     *
     * @return self
     */
    public static function of(iterable $sets): self
    {
        $product = self::empty();
        foreach ($sets as $set) {
            $product = $product->with($set);
        }
        return $product;
    }

    /**
     * Returns an empty instance.
     *
     * @return self
     */
    public static function empty(): self
    {
        return new self();
    }

    public function with(iterable $set): self
    {
        $this->sets[] = match (true) {
            is_array($set) => new \ArrayIterator($set),
            $set instanceof \Traversable => new \IteratorIterator($set),
            default => throw new InvalidArgumentException('Set must be either an array or Traversable'),
        };

        $this->computeReferenceSet();

        return $this;
    }

    public function current(): array
    {
        if (!$this->valid()) {
            return [];
        }

        $current = $this->referenceSet->current();

        return (array) $current;
    }

    public function next(): void
    {
        $this->cursor++;
        $this->referenceSet->next();
    }

    public function key(): int
    {
        return $this->cursor;
    }

    public function valid(): bool
    {
        return $this->referenceSet->valid();
    }

    public function rewind(): void
    {
        $this->cursor = 0;
        $this->referenceSet->rewind();
    }

    public function toArray(): array
    {
        $product = [];

        $this->rewind();

        while ($this->valid()) {
            $product[] = $this->current();
            $this->next();
        }

        return $product;
    }

    private function computeReferenceSet(): void
    {
        $sets = array_reverse($this->sets);
        $this->referenceSet = array_shift($sets);

        foreach ($sets as $set) {
            $this->referenceSet = new Set($set, $this->referenceSet);
        }
    }
}
