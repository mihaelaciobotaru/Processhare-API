<?php
namespace AppBundle\Comparator;

interface ComparatorInterface
{
    /**
     * A method that compares the two numbers and returns the result
     *
     * @param $a
     * @param $b
     * @return bool
     */
    public function compare($a, $b) : bool;
}