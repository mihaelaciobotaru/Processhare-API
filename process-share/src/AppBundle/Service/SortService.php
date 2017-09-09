<?php
namespace AppBundle\Service;

class SortService
{
    public function __construct()
    {
    }

    public function sort(array $numbers)
    {
        $size = count($numbers);
        for ($i=0; $i<$size; $i++) {
            for ($j=0; $j<$size-1-$i; $j++) {
                if ($numbers[$j+1] < $numbers[$j]) {
                    $this->swap($numbers, $j, $j+1);
                }
            }
        }
        return $numbers;
    }

    public function swap(&$arr, $a, $b)
    {
        $tmp = $arr[$a];
        $arr[$a] = $arr[$b];
        $arr[$b] = $tmp;
    }
}
