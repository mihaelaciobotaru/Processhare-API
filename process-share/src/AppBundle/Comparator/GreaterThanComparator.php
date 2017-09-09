<?php
namespace AppBundle\Comparator;

class GreaterThanComparator implements ComparatorInterface
{
    public function compare($a, $b): bool
    {
        return $a > $b;
    }
}