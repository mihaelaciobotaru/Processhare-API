<?php
namespace Tests\AppBundle\Comparator;

use AppBundle\Comparator\LesserThanComparator;
use PHPUnit\Framework\TestCase;

class LesserThanComparatorTest extends TestCase
{
    public function testCompare()
    {
        $comparator = new LesserThanComparator();

        $result = $comparator->compare(10, 5);
        $this->assertFalse($result);

        $result = $comparator->compare( 5, 10);
        $this->assertTrue($result);
    }
}