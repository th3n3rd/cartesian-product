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

use Iterator;

/**
 * Class CartesianProduct.
 *
 * @package   Nerd\CartesianProduct
 * @author    Marco Garofalo <marcogarofalo.personal@gmail.com>
 */
class CartesianProduct implements Iterator
{
    /**
     * @var array
     */
    private $sets;

    /**
     * @var Set
     */
    private $referenceSet;

    /**
     * @var int
     */
    private $cursor;

    /**
     * Constructor.
     *
     * @param array $sets
     */
    public function __construct(array $sets = array())
    {
        $this->cursor = 0;
        $this->sets = array();
        foreach ($sets as $set) {
            $this->appendSet($set);
        }
    }

    /**
     * Appends the given set.
     *
     * @param array $set
     *
     * @return $this
     */
    public function appendSet(array $set)
    {
        $this->sets[] = $set;
        $this->computeReferenceSet();
        return $this;
    }

    /**
     * Computes the reference set used for iterate over the product.
     *
     * @return void
     */
    private function computeReferenceSet()
    {
        if (empty($this->sets)) {
            return;
        }
        $sets = array_reverse($this->sets);
        $this->referenceSet = new Set(array_shift($sets));
        foreach ($sets as $set) {
            $this->referenceSet = new LinkedSet($this->referenceSet, $set);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->referenceSet->current();
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