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

use Countable;
use Iterator;

/**
 * Class Set.
 *
 * @package   Nerd\CartesianProduct
 * @author    Marco Garofalo <marcogarofalo.personal@gmail.com>
 */
class Set implements Iterator, Countable
{
    /**
     * @var array
     */
    protected $values;

    /**
     * @var int
     */
    protected $cursor;

    /**
     * Constructor.
     *
     * @param array $values
     */
    public function __construct(array $values = array())
    {
        $this->cursor = 0;
        $this->values = array_unique($values);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->values[$this->cursor];
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->cursor++;
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
        return isset($this->values[$this->cursor]);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->cursor = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->values);
    }
}