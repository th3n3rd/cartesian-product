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

/**
 * Class LinkedSet.
 *
 * @package   Nerd\CartesianProduct
 * @author    Marco Garofalo <marcogarofalo.personal@gmail.com>
 */
class LinkedSet extends Set
{
    /**
     * @var Set
     */
    private $neighbour;

    /**
     * Constructor.
     *
     * @param Set $neighbour
     * @param array       $values
     */
    public function __construct(Set $neighbour, array $values = array())
    {
        parent::__construct($values);
        $this->neighbour = $neighbour;
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

    public function rewind()
    {
        $this->neighbour->rewind();
        parent::rewind();
    }
}