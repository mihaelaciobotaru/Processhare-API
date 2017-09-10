<?php
namespace AppBundle\Comparator;

class LesserThanComparator implements ComparatorInterface
{
    public function compare($a, $b): bool
    {
        return $a < $b;
    }
}