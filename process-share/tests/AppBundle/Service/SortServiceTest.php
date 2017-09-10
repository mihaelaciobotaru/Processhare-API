<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 10.09.2017
 * Time: 03:56
 */

namespace Tests\AppBundle\Service;


use AppBundle\Comparator\GreaterThanComparator;
use AppBundle\Comparator\LesserThanComparator;
use AppBundle\Service\SortService;
use PHPUnit\Framework\TestCase;

class SortServiceTest extends TestCase
{
    public function testSort()
    {
        $sortService = $this->getSortService();
        $numbers = [10, 5, 1];

        $result = $sortService->sort($numbers);

        $this->assertEquals([1, 5, 10], $result);

    }

    private function getSortService()
    {
        $sortService = new SortService();
        $sortService->addComparator(new LesserThanComparator());

        return $sortService;
    }

}