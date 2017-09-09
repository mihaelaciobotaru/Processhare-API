<?php
namespace AppBundle\Service;

use AppBundle\Comparator\ComparatorInterface;

class SortService
{
    private $comparators = array();

    /**
     * @param ComparatorInterface $comparator
     */
    public function addComparator(ComparatorInterface $comparator)
    {
        $this->comparators[] = $comparator;
    }

    /**
     * Sorts an array of numbers using a random comparator
     *
     * @param array $numbers
     * @return array
     */
    public function sort(array $numbers) : array
    {
        $size = count($numbers);

        /** @var ComparatorInterface $comparator */
        $comparator = null;
        if (count($this->comparators) > 0) {
            $comparator = $this->comparators[rand(0, count($this->comparators) - 1)];
        }

        for ($i=0; $i<$size; $i++) {
            for ($j=0; $j<$size-1-$i; $j++) {
                if ($comparator->compare($numbers[$j+1], $numbers[$j])) {
                    $this->swap($numbers, $j, $j+1);
                }
            }
        }
        return $numbers;
    }

    /**
     *
     * Swaps two elements of an array
     * @param $arr
     * @param $a
     * @param $b
     */
    private function swap(&$arr, $a, $b)
    {
        $tmp = $arr[$a];
        $arr[$a] = $arr[$b];
        $arr[$b] = $tmp;
    }
}
